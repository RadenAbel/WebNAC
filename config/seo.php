<?php

/*
|--------------------------------------------------------------------------
| Identitas untuk SEO (Google Search)
|--------------------------------------------------------------------------
| Dipakai data terstruktur (schema.org) di layout publik, sitemap, dan
| robots.txt. Nama & lokasi di sini sebaiknya SAMA PERSIS dengan yang
| dipakai di Google Business Profile, Instagram, dan tempat lain — Google
| lebih percaya bisnis yang identitasnya konsisten di mana-mana.
*/

return [
    'club_name'       => 'Nugroho Aquatic Club',
    'alternate_names' => ['NAC', 'NAC Swim School'],
    'venue_name'      => 'Everglade Aquatic Center',
    'locality'        => 'Sangatta Utara',
    'region'          => 'Kalimantan Timur',
    'area_served'     => ['Sangatta', 'Kutai Timur', 'Kalimantan Timur'],

    'default_title'       => 'Nugroho Aquatic Club — Klub Renang di Sangatta, Kutai Timur',
    'default_description' => 'Nugroho Aquatic Club (NAC) — klub dan sekolah renang di Sangatta Utara, Kutai Timur. Latihan di Everglade Aquatic Center bersama pelatih bersertifikat, dari pemula hingga atlet.',

    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),
];