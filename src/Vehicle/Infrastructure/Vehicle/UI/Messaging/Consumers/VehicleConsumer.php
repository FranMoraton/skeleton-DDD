<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\UI\Messaging\Consumers;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Skeleton\Vehicle\Infrastructure\Vehicle\UI\Messaging\Subscribers\VehicleWasCreatedSubscriber;
use Skeleton\Vehicle\Infrastructure\Vehicle\UI\Messaging\Subscribers\VehicleWasDeletedSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class VehicleConsumer implements ConsumerInterface
{
    private const MAX_RETRIES = 5;
    private const TIME_TO_RETRY = 10000;

    const EVENT_SUBSCRIBERS = [
        'skeleton.vehicle.event.1.vehicle.wasCreated' => [VehicleWasCreatedSubscriber::class],
        'skeleton.vehicle.event.1.vehicle.wasUpdated' => [VehicleWasUpdatedSubscriber::class],
        'skeleton.vehicle.event.1.vehicle.wasDeleted' => [VehicleWasDeletedSubscriber::class],
    ];

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var bool
     */
    private $failed;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->failed = false;
    }

    /**
     * @param AMQPMessage $msg The message
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        if ($this->failed)
            exit();

        if ($msg) {
            $data = json_decode($msg->getBody(), true);

            try {
                if (isset($data['headers']['name']) && array_key_exists($data['headers']['name'], self::EVENT_SUBSCRIBERS)) {
                    $this->openConnection();
                    $entityManager = $this->container->get('doctrine')->getManager();
                    $entityManager->beginTransaction();

                    $subscribers = self::EVENT_SUBSCRIBERS[$data['headers']['name']];
                    foreach ($subscribers as $subscriberClass){
                        $subscriber = $this->container->get($subscriberClass);
                        $event = $subscriber->hydrate($data['body']);
                        $status = $subscriber->handle($event);
                    }

                    $entityManager->flush();
                    $entityManager->commit();
                    $this->closeConnection();

                    return $status;
                }
            } catch (\Throwable $exception) {
                $this->rollback();
                $this->closeConnection();
                $this->failed = true;
                if (false === $this->retry($msg, $data ?? []))
                    return ConsumerInterface::MSG_REJECT;
            }
        }
    }

    private function retry(AMQPMessage $msg, $data): bool
    {
        $retried = true;
        $headers = isset($msg->get_properties()['application_headers'])
            ? $msg->get_properties()['application_headers']->getNativeData()
            : [];

        $retries = $headers['retries'] ?? 0;

        $retries++;

        if ($data && self::MAX_RETRIES >= $retries && isset($data['headers']['name'])) {
            $this->container->get('old_sound_rabbit_mq.vehicleDelay_producer')->publish(
                json_encode($data),
                $data['headers']['name'],
                ['expiration' => self::TIME_TO_RETRY * $retries],
                ['retries' => $retries]
            );
        }

        if (false === isset($data) || self::MAX_RETRIES < $retries) {
            $retried = false;
        }

        return $retried;
    }


    private function openConnection(): void
    {
        $entityManager = $this->container->get('doctrine')->getManager();
        if (!$entityManager->isOpen()) {
            $this->container->get('doctrine')->resetManager();
        }
    }

    private function closeConnection(): void
    {
        $entityManager = $this->container->get('doctrine')->getManager();
        if ($entityManager->isOpen()) {
            $entityManager->clear();
            $connection = $entityManager->getConnection();
            if ($connection->isConnected()) {
                $connection->close();
            }
        }
    }

    private function rollback() : void
    {
        $entityManager = $this->container->get('doctrine')->getManager();
        if ($entityManager->isOpen() &&
            $entityManager->getConnection()->isTransactionActive())
            $entityManager->rollback();
    }
}
