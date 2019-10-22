<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Skeleton\Kernel\Domain\Model\StoredEvent;
use Skeleton\Kernel\Domain\Model\StoredEventRepository;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;

final class DoctrineStoredEventRepository implements StoredEventRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(StoredEvent $event): void
    {
        $this->entityManager->persist($event);
    }

    public function nextIdEntity(): string
    {
        return Uuid::v4();
    }

    public function persist(StoredEvent $event): void
    {
        $this->entityManager->flush($event);
    }
}
