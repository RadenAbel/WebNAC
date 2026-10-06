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
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('location', 150)->nullable()->after('event_date');
        });

        $used = [];
        foreach (DB::table('events')->orderBy('id')->get(['id', 'title']) as $row) {
            $base = Str::slug((string) $row->title) ?: 'kejuaraan';
            $slug = $base;
            $i = 2;
            while (in_array($slug, $used, true)) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $used[] = $slug;
            DB::table('events')->where('id', $row->id)->update(['slug' => $slug]);
        }

        if (Schema::hasColumn('events', 'pdf_report')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('pdf_report');
            });
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('pdf_report')->nullable()->after('description');
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'location']);
        });
    }
};
