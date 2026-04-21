<?php

namespace App\Assembler;

use App\DTO\LogDTO;
use App\Entity\User;
use App\Enum\LogState;

class LogEntryAssembler
{
    public static function fromEntity(object $entity, LogState $action, array $changes, User $user): LogDTO
    {
        $dto = new LogDTO();
        $dto->entity = (new \ReflectionClass($entity))->getShortName();
        $dto->entityId = $entity->getId();
        $dto->action = $action;
        $dto->changes = $changes;
        $dto->user = $user;

        return $dto;
    }
}