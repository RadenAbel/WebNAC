<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = ['title', 'subtitle', 'button_text', 'button_url'];

    public function up(): void
    {
        $existing = array_values(array_filter(
            $this->columns,
            fn ($column) => Schema::hasColumn('sliders', $column)
        ));

        if ($existing) {
            Schema::table('sliders', function (Blueprint $table) use ($existing) {
                $table->dropColumn($existing);
            });
        }
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (! Schema::hasColumn('sliders', 'title')) {
                $table->string('title')->nullable();
            }
            if (! Schema::hasColumn('sliders', 'subtitle')) {
                $table->string('subtitle')->nullable();
            }
            if (! Schema::hasColumn('sliders', 'button_text')) {
                $table->string('button_text')->nullable();
            }
            if (! Schema::hasColumn('sliders', 'button_url')) {
                $table->string('button_url')->nullable();
            }
        });
    }
};
