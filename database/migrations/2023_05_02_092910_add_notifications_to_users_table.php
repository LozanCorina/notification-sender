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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('id');
            $table->boolean('phone_unreachable')->default(false)->after('phone');
            $table->string('push_notifications_token')->nullable()->after('phone_unreachable');

            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('phone_unreachable');
            $table->dropColumn('push_notifications_token');
        });
    }
};
