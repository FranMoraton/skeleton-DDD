<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Application;

use Skeleton\Kernel\Application\EventNotification;
use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Service\TransformIntoArrayService;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class QueueEventNotification implements EventNotification
{
    private const CONTEXT_EXCHANGES_LOADED = [
        'example' => 'example'
    ];

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function publish(DomainEvent $domainEvent, array $headers = [])
    {
        $data = [
            'headers' => [
                'name' => $domainEvent::getNameEvent()
            ],
            'body' => TransformIntoArrayService::objectToArray($domainEvent)
        ];

        $context = null;

        $nameEvent = explode('.', $domainEvent::getNameEvent());
        if (isset($nameEvent[1])) {
            $context = $nameEvent[1];
        }

        if (null === $context || false === array_key_exists($context, self::CONTEXT_EXCHANGES_LOADED))
            throw new \Exception(
                'Exchange from context does not found please make sure your name event is correct'
            );

        $this->container->get('old_sound_rabbit_mq.'.$context.'_producer')->publish(
            json_encode($data),
            $domainEvent::getNameEvent(),
            [],
            $headers
        );
    }
}
