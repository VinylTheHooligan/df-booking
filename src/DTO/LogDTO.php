<?php

namespace App\DTO;

use App\Entity\User;
use App\Enum\LogState;

class LogDTO
{
    public string $entity;
    public int $entityId;
    public LogState $action;
    public array $changes = [];
    public User $user;
}