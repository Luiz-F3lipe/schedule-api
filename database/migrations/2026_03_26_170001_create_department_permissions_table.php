<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        Schema::create('department_permissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['department_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_permissions');
    }
};
