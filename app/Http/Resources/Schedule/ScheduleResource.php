<?php

declare(strict_types = 1);

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'client_name'     => $this->client_name,
            'responsible_by'  => $this->user->name,
            'scheduled_at'    => $this->scheduled_at,
            'initial_time'    => $this->initial_time,
            'final_time'      => $this->final_time,
            'schedule_status' => $this->schedule_status->description,
            'canceled_at'     => $this->canceled_at,
        ];
    }
}
