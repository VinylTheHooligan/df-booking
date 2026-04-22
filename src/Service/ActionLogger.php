<?php

namespace App\Service;

use App\DTO\LogDTO;
use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;

class ActionLogger
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function createEntityFromDTO(LogDTO $dto): Log
    {
        $log = new Log();
        $log->setEntity($dto->entity);
        $log->setEntityClass($dto->entityClass);
        $log->setEntityId($dto->entityId);
        $log->setAction($dto->action->value);
        $log->setChanges($dto->changes);
        $log->setUser($dto->user);
        $log->setCreatedAt(new \DateTimeImmutable());

        return $log;
    }

    public function logToDatabase(LogDTO $dto): void
    {
        $log = $this->createEntityFromDTO($dto);
        $this->em->persist($log);
        $this->em->flush();
    }
}