<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            // ==== PELATIH ====
            [
                'name' => 'Agus Nugroho',
                'age' => 45,
                'role' => 'pelatih',
                'category' => 'Head Coach',
                'bio' => 'Pendiri sekaligus kepala pelatih Nugroho Aquatic Center, 20+ tahun pengalaman.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Dewi Kartika',
                'age' => 34,
                'role' => 'pelatih',
                'category' => 'Assistant Coach',
                'bio' => 'Fokus melatih kelompok junior dan teknik dasar renang.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Rian Saputra',
                'age' => 29,
                'role' => 'pelatih',
                'category' => 'Fitness Coach',
                'bio' => 'Menangani program kekuatan dan kondisi fisik atlet.',
                'sort_order' => 3,
            ],

            // ==== ATLET ====
            [
                'name' => 'Bagas Prasetyo',
                'age' => 12,
                'role' => 'atlet',
                'category' => 'Junior',
                'bio' => 'Atlet junior berbakat, spesialis gaya bebas.',
                'sort_order' => 10,
            ],
            [
                'name' => 'Citra Ayu',
                'age' => 16,
                'role' => 'atlet',
                'category' => 'Swim Class A',
                'bio' => 'Peraih medali emas kejuaraan renang daerah 2025.',
                'sort_order' => 11,
            ],
            [
                'name' => 'Fajar Ramadhan',
                'age' => 20,
                'role' => 'atlet',
                'category' => 'Senior',
                'bio' => 'Atlet senior, spesialis gaya kupu-kupu.',
                'sort_order' => 12,
            ],
            [
                'name' => 'Intan Permata',
                'age' => 14,
                'role' => 'atlet',
                'category' => 'Swim Class B',
                'bio' => 'Sedang mengembangkan teknik gaya punggung.',
                'sort_order' => 13,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }
}