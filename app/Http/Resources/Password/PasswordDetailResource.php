<?php

declare(strict_types = 1);

namespace App\Http\Resources\Password;

use App\Http\Resources\Department\DepartmentResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PasswordDetailResource extends JsonResource
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
            'password'    => $this->password,
            'observation' => $this->observation,
            'department'  => DepartmentResource::make($this->department),
            'product'     => ProductResource::make($this->product),
        ];
    }
}
