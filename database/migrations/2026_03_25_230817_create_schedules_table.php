<?php

declare(strict_types = 1);

use App\Models\Department;
use App\Models\Product;
use App\Models\ScheduleStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table): void {
            $table->id();
            $table->integer('client_id');
            $table->string('client_name');
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Department::class)->constrained();
            $table->foreignIdFor(User::class, 'responsible_by')->constrained(table: 'users');
            $table->date('scheduled_at');
            $table->time('initial_time');
            $table->time('final_time')->nullable();
            $table->foreignIdFor(ScheduleStatus::class)->constrained(table: 'schedule_status');
            $table->text('description')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->constrained(table: 'users');
            $table->dateTime('canceled_at')->nullable();
            $table->string('canceled_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
