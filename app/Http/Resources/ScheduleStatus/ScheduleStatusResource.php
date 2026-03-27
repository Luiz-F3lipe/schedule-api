<?php

declare(strict_types = 1);

namespace App\Http\Resources\ScheduleStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleStatusResource extends JsonResource
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
            'id'          => $this->id,
            'description' => $this->description,
            'color'       => $this->color,
            'active'      => $this->active,
        ];
    }
}
