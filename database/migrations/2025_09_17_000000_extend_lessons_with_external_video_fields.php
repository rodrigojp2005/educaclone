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
            // Flags
            $table->boolean('is_external')->default(false)->after('provider_signed');
            $table->boolean('is_teaser')->default(false)->after('is_external');
            $table->boolean('is_active')->default(true)->after('is_teaser');

            // External source metadata (for YouTube or outros)
            $table->string('source_url')->nullable()->after('is_active');
            $table->string('source_channel_title')->nullable()->after('source_url');
            $table->string('source_channel_url')->nullable()->after('source_channel_title');
            $table->enum('source_license_type', ['standard', 'creative_commons', 'unknown'])->default('unknown')->after('source_channel_url');

            // Media / technical
            $table->string('thumbnail_url')->nullable()->after('source_license_type');
            $table->integer('duration_seconds')->nullable()->after('thumbnail_url');

            // Health check
            $table->timestamp('last_checked_at')->nullable()->after('duration_seconds');
            $table->enum('check_status', ['ok', 'missing', 'blocked'])->default('ok')->after('last_checked_at');

            // Indexes úteis
            $table->index(['is_external', 'provider']);
            $table->index(['check_status']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropIndex(['lessons_is_external_provider_index']);
            $table->dropIndex(['lessons_check_status_index']);
            $table->dropIndex(['lessons_is_active_index']);
            $table->dropColumn([
                'is_external',
                'is_teaser',
                'is_active',
                'source_url',
                'source_channel_title',
                'source_channel_url',
                'source_license_type',
                'thumbnail_url',
                'duration_seconds',
                'last_checked_at',
                'check_status',
            ]);
        });
    }
};
