<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Password extends Model
{
    /** @use HasFactory<\Database\Factories\PasswordFactory> */
    use HasFactory;

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class)->withDefault();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
