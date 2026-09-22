<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Index untuk kolom yang dipakai di hampir setiap halaman:
 * filter "aktif" (scope active()) lalu diurutkan (sort_order / tanggal).
 *
 * Index gabungan disusun sesuai urutan query-nya — kolom yang difilter
 * dulu, baru kolom yang dipakai untuk mengurutkan — supaya MySQL bisa
 * langsung membaca hasil yang sudah terurut tanpa menyortir ulang.
 *
 * Kolom foreign key (team_member_id di rekor/prestasi/lisensi) tidak
 * perlu ditambah di sini: MySQL sudah otomatis memberi index di situ.
 */
return new class extends Migration
{
    /**
     * [tabel => [nama_index => [kolom, ...]]]
     */
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
            // hitungan "menunggu tinjauan" di sidebar admin + filter status
            'join_requests_status_created_idx' => ['status', 'created_at'],
            // daftar pendaftaran diurutkan dari yang terbaru
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
                    // Lewati kalau ada kolom yang tidak ada di tabel ini
                    // (jaga-jaga struktur database berbeda dari yang diharapkan).
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