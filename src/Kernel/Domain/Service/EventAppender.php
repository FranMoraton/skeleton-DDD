<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Domain\Service;

use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Model\StoredEvent;
use Skeleton\Kernel\Domain\Model\StoredEventRepository;

final class EventAppender
{
    /**
     * @var StoredEventRepository
     */
    private $storedEventRepository;

    public function __construct(StoredEventRepository $storedEventRepository)
    {
        $this->storedEventRepository = $storedEventRepository;
    }
    public function append(DomainEvent $domainEvent): StoredEvent
    {
        $storedEvent = new StoredEvent(
            $this->storedEventRepository->nextIdEntity(),
            $domainEvent::getNameEvent(),
            new \DateTime(),
            json_encode(TransformIntoArrayService::objectToArray($domainEvent)),
        );

        $this->storedEventRepository->add($storedEvent);

        return $storedEvent;
    }
}
