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
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('type');
            $table->string('provider_video_id')->nullable()->after('provider');
            $table->boolean('provider_signed')->default(true)->after('provider_video_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['provider', 'provider_video_id', 'provider_signed']);
        });
    }
};
