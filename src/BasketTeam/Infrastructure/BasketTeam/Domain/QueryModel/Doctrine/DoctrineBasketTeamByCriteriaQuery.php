<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\Domain\QueryModel\Doctrine;

use Doctrine\DBAL\Connection;
use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamByCriteriaQuery;
use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamByCriteriaQuery;

final class DoctrineBasketTeamByCriteriaQuery implements BasketTeamByCriteriaQuery
{
    public const DEFAULT_ORDER_BY = 'averageRating';
    private const ORDER_BY = [
        'number' => 'number',
        'average_rating' => 'average_rating',
        'averageRating' => 'average_rating'
    ];

    public const DEFAULT_ORDER_DIRECTION = 'desc';
    private const ORDER_DIRECTION = [
        'desc' => 'desc',
        'asc' => 'asc'
    ];

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(GetBasketTeamByCriteriaQuery $query): array
    {
        $teamFields = 'team.id, team.name';
        $playerFields = 'player.number, player.average_rating' .
            ', player.name as playerName, player.role';

        $qb = $this->connection->createQueryBuilder();
        $qb->select($teamFields)
            ->addSelect($playerFields)
            ->from('team', 'team')
            ->innerJoin(
                'team',
                'player',
                'player',
                'team.id = player.team_id'
            )
            ->orderBy(
                $this->selectOrderBy(
                    $query->orderBy()
                ),
                $this->selectOrderDirection(
                    $query->order()
                )
            );

        if (null !== $query->teamId()) {
            $qb->andWhere('player.team_id = :teamId')
                ->setParameter('teamId', $query->teamId());
        }

        if (null !== $query->name()) {
            $qb->andWhere('team.name = :teamName')
                ->setParameter('teamName', $query->name());
        }

        $results = $qb->execute()
            ->fetchAll();

        return $this->makeProjection($results);
    }

    private function selectOrderBy(?string $orderBy): string
    {
        return self::ORDER_BY[strtolower((string)$orderBy)] ?? self::ORDER_BY[self::DEFAULT_ORDER_BY];
    }

    private function selectOrderDirection(?string $order): string
    {
        return self::ORDER_DIRECTION[strtolower((string)$order)] ?? self::ORDER_DIRECTION[self::DEFAULT_ORDER_DIRECTION];
    }

    private function makeProjection(array $results): array
    {
        $projection = [];
        foreach ($results as $result) {
            if (false === array_key_exists('players', $projection[$result['id']])) {
                $projection[$result['id']]['players'] = [];
            }
            $projection[$result['id']]['id'] = $result['id'];
            $projection[$result['id']]['name'] = $result['name'];
            $projection[$result['id']]['players'][$result['number']] = [
                'number' => $result['number'],
                'averageRating' => $result['average_rating'],
                'name' => $result['playerName'],
                'role' => $result['role'],
            ];
        }

        return $projection;
    }
}
