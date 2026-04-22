<?php

namespace App\Assembler;

use App\DTO\LogDTO;
use App\Entity\User;
use App\Enum\LogState;

class LogEntryAssembler
{
    public function fromEntity(
        object $entity,
        LogState $action,
        User $user,
        array $changes
    ): LogDTO {
        $dto = new LogDTO();
        $dto->entity = (new \ReflectionClass($entity))->getShortName();
        $dto->entityClass = get_class($entity);
        $dto->entityId = $entity->getId();
        $dto->action = $action;
        $dto->changes = $changes;
        $dto->user = $user;

        return $dto;
    }
}
