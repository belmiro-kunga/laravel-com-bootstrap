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
            $table->json('notification_preferences')->nullable()->after('last_login_at');
            $table->boolean('email_notifications')->default(true)->after('notification_preferences');
            $table->boolean('status_change_notifications')->default(true)->after('email_notifications');
            $table->boolean('urgent_notifications')->default(true)->after('status_change_notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notification_preferences',
                'email_notifications',
                'status_change_notifications',
                'urgent_notifications'
            ]);
        });
    }
};
