<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\Domain\QueryModel\Doctrine;

use Doctrine\DBAL\Connection;
use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamPlayerByNumberQuery;
use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamPlayerByNumberQuery;

final class DoctrineBasketTeamPlayerByNumberQuery implements BasketTeamPlayerByNumberQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(GetBasketTeamPlayerByNumberQuery $query): array
    {
        $fields = 'player.number, player.average_rating as averageRating' .
            ', player.name, player.role, player.team_id as teamId';

        return $this->connection->createQueryBuilder()
            ->select($fields)
            ->from('player', 'player')
            ->where('player.team_id = :teamId')
            ->setParameter('teamId', $query->teamId())
            ->andWhere('player.number = :number')
            ->setParameter('number', $query->playerNumber())
            ->execute()
            ->fetch() ?: [];
    }
}
