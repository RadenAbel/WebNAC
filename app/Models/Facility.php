<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use FlushesPublicCache;

    protected $fillable = [
        'name',
        'description',
        'highlights',
        'photo',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active'  => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getHighlightListAttribute(): array
    {
        if (! $this->highlights) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $this->highlights))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /** Kata kunci ikon poin keunggulan => [kelas Font Awesome, label]. */
    public const HIGHLIGHT_ICONS = [
        'check'      => ['fa-solid fa-check', 'Centang'],
        'kolam'      => ['fa-solid fa-person-swimming', 'Renang'],
        'air'        => ['fa-solid fa-droplet', 'Air'],
        'suhu'       => ['fa-solid fa-temperature-half', 'Suhu'],
        'wifi'       => ['fa-solid fa-wifi', 'WiFi'],
        'hp'         => ['fa-solid fa-mobile-screen', 'Ponsel'],
        'laptop'     => ['fa-solid fa-laptop', 'Laptop'],
        'kelas'      => ['fa-solid fa-chalkboard-user', 'Kelas'],
        'buku'       => ['fa-solid fa-book-open', 'Buku'],
        'diskusi'    => ['fa-solid fa-comments', 'Diskusi'],
        'pelatih'    => ['fa-solid fa-user-tie', 'Pelatih'],
        'grup'       => ['fa-solid fa-users', 'Grup'],
        'piala'      => ['fa-solid fa-trophy', 'Piala'],
        'medali'     => ['fa-solid fa-medal', 'Medali'],
        'bintang'    => ['fa-solid fa-star', 'Bintang'],
        'stopwatch'  => ['fa-solid fa-stopwatch', 'Stopwatch'],
        'jam'        => ['fa-solid fa-clock', 'Jam'],
        'aman'       => ['fa-solid fa-shield-halved', 'Keamanan'],
        'cctv'       => ['fa-solid fa-video', 'CCTV'],
        'medis'      => ['fa-solid fa-kit-medical', 'Medis'],
        'loker'      => ['fa-solid fa-lock', 'Loker'],
        'shower'     => ['fa-solid fa-shower', 'Shower'],
        'toilet'     => ['fa-solid fa-restroom', 'Toilet'],
        'parkir'     => ['fa-solid fa-square-parking', 'Parkir'],
        'ac'         => ['fa-solid fa-snowflake', 'AC'],
        'lampu'      => ['fa-solid fa-lightbulb', 'Lampu'],
        'kursi'      => ['fa-solid fa-chair', 'Tribun'],
        'kafe'       => ['fa-solid fa-mug-hot', 'Kafe'],
        'daun'       => ['fa-solid fa-leaf', 'Alami'],
        'gedung'     => ['fa-solid fa-building', 'Gedung'],
    ];

    /**
     * Poin keunggulan sebagai ikon + subjudul + penjelasan.
     * Format per baris: "[ikon] Subjudul | Penjelasan" (ikon & penjelasan opsional).
     */
    public function getHighlightItemsAttribute(): array
    {
        return collect($this->highlight_list)
            ->map(function ($line) {
                $icon = self::HIGHLIGHT_ICONS['check'][0];

                if (preg_match('/^\[([\w-]+)\]\s*/u', $line, $m)) {
                    $icon = self::HIGHLIGHT_ICONS[strtolower($m[1])][0] ?? $icon;
                    $line = substr($line, strlen($m[0]));
                }

                [$title, $text] = array_pad(explode('|', $line, 2), 2, null);

                return [
                    'icon'  => $icon,
                    'title' => trim($title),
                    'text'  => $text !== null ? trim($text) : null,
                ];
            })
            ->filter(fn ($item) => $item['title'] !== '' || $item['text'])
            ->values()
            ->all();
    }
}
