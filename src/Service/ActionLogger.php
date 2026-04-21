<?php

namespace App\Service;

use App\DTO\LogDTO;
use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;

class ActionLogger
{

    public function __construct(
        private EntityManagerInterface $em,
    )
    {}

    public function LogEntry(LogDTO $dto): Log
    {
        $log = new Log();
        $log->setEntity($dto->entity);
        $log->setEntityId($dto->entityId);
        $log->setAction($dto->action->value);
        $log->setChanges($dto->changes);
        $log->setUser($dto->user);
        $log->setCreatedAt(new \DateTimeImmutable());
        
        return $log;
    }

    public function LogToDatabase(LogDTO $logDTO): void
    {
        $this->em->persist($logDTO);
        $this->em->flush();
    }
}