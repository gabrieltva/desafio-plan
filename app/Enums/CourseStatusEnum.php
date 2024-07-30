<?php

namespace App\Enums;

enum CourseStatusEnum: string
{
    case NotStarted = 'NOT_STARTED';
    case Completed = 'COMPLETED';
    case Cancelled = 'CANCELLED';
}
