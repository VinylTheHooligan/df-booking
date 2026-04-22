<?php

namespace App\DTO;

use App\Entity\User;
use App\Enum\LogState;

class LogDTO
{
    public string $entity;
    public string $entityClass;
    public int $entityId;
    public LogState $action;
    public array $changes = [];
    public ?User $user = null;
}