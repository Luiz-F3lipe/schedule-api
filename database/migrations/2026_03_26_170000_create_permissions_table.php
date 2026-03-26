<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // create_department, edit_product, etc
            $table->string('resource'); // department, product, schedule_status, system, user
            $table->string('action'); // create, edit, list, show, delete
            $table->timestamps();

            $table->unique(['resource', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
