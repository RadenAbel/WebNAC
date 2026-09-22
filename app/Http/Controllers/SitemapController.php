<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Support\PublicCache;

class SitemapController extends Controller
{
    /**
     * /sitemap.xml — daftar semua halaman publik untuk Google. Profil atlet/
     * pelatih dan hasil pertandingan ikut otomatis. Di-cache lewat
     * PublicCache, jadi otomatis diperbarui setiap admin menambah/mengubah
     * data (tidak perlu dibuat ulang manual).
     */
    public function index()
    {
        $xml = PublicCache::remember('sitemap', function () {
            $urls = [
                ['loc' => route('home'),          'changefreq' => 'weekly',  'priority' => '1.0'],
                ['loc' => route('about.index'),   'changefreq' => 'monthly', 'priority' => '0.9'],
                ['loc' => route('join.create'),   'changefreq' => 'monthly', 'priority' => '0.9'],
                ['loc' => route('team.athletes'), 'changefreq' => 'weekly',  'priority' => '0.8'],
                ['loc' => route('team.coaches'),  'changefreq' => 'monthly', 'priority' => '0.8'],
                ['loc' => route('event.index'),   'changefreq' => 'weekly',  'priority' => '0.8'],
                ['loc' => route('gallery.index'), 'changefreq' => 'weekly',  'priority' => '0.6'],
            ];

            foreach (TeamMember::active()->get(['id', 'updated_at']) as $member) {
                $urls[] = [
                    'loc'        => route('team.show', $member),
                    'lastmod'    => $member->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.6',
                ];
            }

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            foreach ($urls as $url) {
                $xml .= "  <url>\n";
                $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1) . "</loc>\n";
                if (! empty($url['lastmod'])) {
                    $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
                }
                $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
                $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
                $xml .= "  </url>\n";
            }
            $xml .= '</urlset>';

            return $xml;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * /robots.txt — dibuat dinamis supaya alamat sitemap otomatis mengikuti
     * domain yang dipakai (APP_URL), tidak perlu diedit manual saat online.
     * PENTING: hapus file public/robots.txt bawaan Laravel, karena kalau file
     * itu ada, web server menampilkannya dan route ini tidak pernah terpanggil.
     */
    public function robots()
    {
        $body = implode("\n", [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
            '',
        ]);

        return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}