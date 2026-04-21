<?php

namespace App\Enum;

enum LogState: string {
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
}