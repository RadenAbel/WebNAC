<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $indexes = [
        'team_members' => [
            'team_members_role_active_sort_idx' => ['role', 'is_active', 'sort_order'],
        ],
        'sliders' => [
            'sliders_active_sort_idx' => ['is_active', 'sort_order'],
        ],
        'galleries' => [
            'galleries_active_sort_idx' => ['is_active', 'sort_order'],
        ],
        'schedules' => [
            'schedules_active_sort_idx' => ['is_active', 'sort_order'],
        ],
        'events' => [
            'events_active_date_idx' => ['is_active', 'event_date'],
        ],
        'management_members' => [
            'management_members_active_sort_idx' => ['is_active', 'sort_order'],
        ],
        'pricing_plans' => [
            'pricing_plans_active_sort_idx' => ['is_active', 'sort_order'],
        ],
        'join_requests' => [
            'join_requests_status_created_idx' => ['status', 'created_at'],
            'join_requests_created_idx'        => ['created_at'],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
                foreach ($indexes as $name => $columns) {
                    foreach ($columns as $column) {
                        if (! Schema::hasColumn($table, $column)) {
                            continue 2;
                        }
                    }

                    if (! Schema::hasIndex($table, $name)) {
                        $blueprint->index($columns, $name);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
                foreach (array_keys($indexes) as $name) {
                    if (Schema::hasIndex($table, $name)) {
                        $blueprint->dropIndex($name);
                    }
                }
            });
        }
    }
};
