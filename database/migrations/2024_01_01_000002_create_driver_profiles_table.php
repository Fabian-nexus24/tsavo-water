<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('national_id')->unique();
            $table->string('vehicle_type');
            $table->string('vehicle_plate');
            $table->enum('availability', ['available', 'busy', 'offline'])->default('offline');
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('total_deliveries')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_profiles');
    }
};
