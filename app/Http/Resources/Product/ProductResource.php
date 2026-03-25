<?php

declare(strict_types = 1);

namespace App\Http\Resources\Product;

use App\Http\Resources\System\SystemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'system'      => SystemResource::make($this->system),
        ];
    }
}
