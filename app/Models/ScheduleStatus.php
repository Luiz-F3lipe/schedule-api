<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleStatus extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleStatusFactory> */
    use HasFactory;

    protected $table = 'schedule_status';
}
