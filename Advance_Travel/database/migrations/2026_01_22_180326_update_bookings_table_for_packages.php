<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'name')) {
                $table->renameColumn('name', 'firstname');
            }
            if (!Schema::hasColumn('bookings', 'lastname')) {
                $table->string('lastname')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'check_in_date')) {
                $table->date('check_in_date')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'check_out_date')) {
                $table->date('check_out_date')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'accommodation')) {
                $table->string('accommodation')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'rooms')) {
                $table->integer('rooms')->default(1);
            }
            if (!Schema::hasColumn('bookings', 'room_type')) {
                $table->string('room_type')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'additional')) {
                $table->text('additional')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'package_title')) {
                $table->string('package_title')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'package_location')) {
                $table->string('package_location')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'package_price')) {
                $table->decimal('package_price', 12, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('firstname', 'name');

            $table->dropColumn([
                'lastname',
                'check_in_date',
                'check_out_date',
                'accommodation',
                'rooms',
                'room_type',
                'additional',
                'package_title',
                'package_location',
                'package_price'
            ]);
        });
    }
};
