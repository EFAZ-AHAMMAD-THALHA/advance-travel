<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add advanced features to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'selected_seats')) {
                $table->string('selected_seats')->nullable()->after('seats');
            }
            if (!Schema::hasColumn('bookings', 'promo_code')) {
                $table->string('promo_code')->nullable()->after('room_type');
            }
            if (!Schema::hasColumn('bookings', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0.00)->after('promo_code');
            }
        });

        // 2. Add profile fields to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'emergency_contact']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['selected_seats', 'promo_code', 'discount_amount']);
        });
    }
};
