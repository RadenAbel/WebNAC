<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('join_cta_photo')->nullable()->after('pool_section_description');
            $table->string('join_cta_title')->nullable()->after('join_cta_photo');
            $table->text('join_cta_description')->nullable()->after('join_cta_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['join_cta_photo', 'join_cta_title', 'join_cta_description']);
        });
    }
};
