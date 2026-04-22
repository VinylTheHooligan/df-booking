<?php

namespace App\Service;

use App\Assembler\LogEntryAssembler;
use App\Entity\User;
use App\Enum\LogState;
use Doctrine\ORM\EntityManagerInterface;

class EntityServiceManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private ActionLogger $logger,
        private LogEntryAssembler $assembler
    ) {}

    public function manage(object $entity, User $user, LogState $state, ?string $customMessage = null): void
    {
        $changes = $this->computeChanges($entity, $state, $customMessage);

        $dto = $this->assembler->fromEntity($entity, $state, $user, $changes);
        $this->logger->logToDatabase($dto);

        if (!$this->em->contains($entity))
        {
            $this->em->persist($entity);
        }

        $this->em->flush();
    }

    public function delete(object $entity, User $user, LogState $state, ?string $customMessage = null): void
    {
        $changes = $this->computeChanges($entity, $state, $customMessage);

        $dto = $this->assembler->fromEntity($entity, $state, $user, $changes);
        $this->logger->logToDatabase($dto);

        $this->em->remove($entity);
        $this->em->flush();
    }

    private function computeChanges(object $entity, LogState $state, ?string $customMessage): array
    {
        if ($customMessage)
        {
            return ['_custom' => [$customMessage, null]];
        }

        if ($state !== LogState::UPDATED)
        {
            return [];
        }

        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();

        return $uow->getEntityChangeSet($entity);
    }
}
