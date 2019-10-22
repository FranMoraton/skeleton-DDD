<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\UI\API\Controller;

use Skeleton\Kernel\Application\Command\CommandBus;
use Skeleton\Kernel\Application\Query\QueryBus;
use Skeleton\Kernel\Domain\Event\FailureDomainEvent;
use Skeleton\Vehicle\Application\Vehicle\Command\CreateVehicleCommand;
use Skeleton\Vehicle\Application\Vehicle\Command\DeleteVehicleCommand;
use Skeleton\Vehicle\Application\Vehicle\Query\GetVehicleByCriteriaQuery;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class VehicleController
{
    use ContainerAwareTrait;

    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var QueryBus
     */
    private $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function createVehicle(Request $request): JsonResponse
    {
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        $name = $request->request->get('name');
        $driver = $request->request->get('driver');

        $command = new CreateVehicleCommand($name, $driver);

        $response = $this->commandBus->execute($command);

        $status = false === $response->first() instanceof FailureDomainEvent ? Response::HTTP_OK : Response::HTTP_CONFLICT;

        return new JsonResponse([], $status);
    }

    public function deleteVehicle(Request $request): JsonResponse
    {
        $id = $request->attributes->get('id');

        $command = new DeleteVehicleCommand($id);

        $this->commandBus->execute($command);

        return new JsonResponse(Response::HTTP_OK);
    }

    public function getVehicles(Request $request): JsonResponse
    {
        $name = $request->query->get('name');

        $query = new GetVehicleByCriteriaQuery();
        $query = $query->withName($name);

        $response = $this->queryBus->execute($query);

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
