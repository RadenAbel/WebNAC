<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            if (! Schema::hasColumn('team_members', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (! Schema::hasColumn('team_members', 'school_name')) {
                $table->string('school_name', 150)->nullable()->after('category');
            }
        });

        $used = ['atlet', 'pelatih'];
        DB::table('team_members')->orderBy('id')->select(['id', 'name'])->each(function ($row) use (&$used) {
            $base = Str::slug($row->name) ?: 'anggota';
            $slug = $base;
            $i = 2;
            while (in_array($slug, $used, true)) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $used[] = $slug;

            DB::table('team_members')->where('id', $row->id)->update(['slug' => $slug]);
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->unique('slug');
        });

        if (Schema::hasColumn('team_members', 'total_achievements')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->dropColumn('total_achievements');
            });
        }
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'school_name']);
            $table->unsignedInteger('total_achievements')->nullable()->default(0);
        });
    }
};
