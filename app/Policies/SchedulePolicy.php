<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function own(User $user, Schedule $schedule): bool
    {
        dd($user->department_id, $schedule->department_id);

        return true;
    }
}
