<?php

declare(strict_types = 1);

namespace App\Http\Resources\Schedule;

use App\Http\Resources\Department\DepartmentResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ScheduleStatus\ScheduleStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'client_id'       => $this->client_id,
            'client_name'     => $this->client_name,
            'responsible_by'  => $this->user?->name,
            'scheduled_at'    => $this->scheduled_at,
            'initial_time'    => $this->initial_time,
            'final_time'      => $this->final_time,
            'description'     => $this->description,
            'created_by'      => $this->createdBy?->name,
            'canceled_at'     => $this->canceled_at,
            'canceled_reason' => $this->canceled_reason,
            'product'         => ProductResource::make($this->product),
            'department'      => DepartmentResource::make($this->department),
            'schedule_status' => ScheduleStatusResource::make($this->schedule_status),
        ];
    }
}
