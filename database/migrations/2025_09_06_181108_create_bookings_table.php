<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->string('accommodation')->nullable();
            $table->integer('rooms')->default(1);
            $table->string('room_type')->nullable();
            $table->text('additional')->nullable();
            $table->string('destination')->nullable();
            $table->string('package_title')->nullable();
            $table->string('package_location')->nullable();
            $table->decimal('package_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
