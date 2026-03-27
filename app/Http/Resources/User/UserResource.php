<?php

declare(strict_types = 1);

namespace App\Http\Resources\User;

use App\Http\Resources\Department\DepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'department' => DepartmentResource::make($this->department),
            'name'       => $this->name,
            'email'      => $this->email,
        ];
    }
}
