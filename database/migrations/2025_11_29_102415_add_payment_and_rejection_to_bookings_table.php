<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('payment_amount', 10, 2)->nullable()->after('end_date');
            $table->text('rejection_reason')->nullable()->after('notes');
            $table->string('refund_proof')->nullable()->after('payment_image');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_amount', 'rejection_reason', 'refund_proof']);
        });
    }
};