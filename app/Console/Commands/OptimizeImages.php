<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use App\Support\ImageOptimizer;
use App\Support\PublicCache;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

#[Signature('images:optimize {--dry-run : Tampilkan gambar yang akan dioptimasi tanpa mengubah apa pun}')]
#[Description('Konversi gambar lama (JPG/PNG) di storage publik ke WebP dan perbarui path-nya di database')]
class OptimizeImages extends Command
{
    private const COLUMNS = [
        'galleries'          => ['image' => 1600],
        'sliders'            => ['image' => 1600],
        'events'             => ['photo' => 1600],
        'facilities'         => ['photo' => 1600],
        'management_members' => ['photo' => 1600],
        'team_members'       => ['photo' => 1600],
        'site_settings'      => [
            'logo'                  => 512,
            'about_photo'           => 1600,
            'classes_section_photo' => 1600,
            'pool_section_photo'    => 1600,
            'join_cta_photo'        => 1600,
            'gallery_header_photo'  => 1600,
            'event_header_photo'    => 1600,
            'team_header_photo'     => 1600,
            'join_header_photo'     => 1600,
        ],
    ];

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $dryRun = (bool) $this->option('dry-run');
        $before = 0;
        $after = 0;
        $converted = 0;

        foreach (self::COLUMNS as $table => $columns) {
            foreach ($columns as $column => $maxDimension) {
                $rows = DB::table($table)
                    ->whereNotNull($column)
                    ->where($column, 'not like', '%.webp')
                    ->get(['id', $column]);

                foreach ($rows as $row) {
                    $path = $row->{$column};

                    if (! preg_match('/\.(jpe?g|png)$/i', $path) || ! $disk->exists($path)) {
                        continue;
                    }

                    $size = $disk->size($path);

                    if ($dryRun) {
                        $this->line(sprintf('%-32s %6d KB  %s', "{$table}.{$column}", $size / 1024, $path));
                        continue;
                    }

                    $file = new UploadedFile($disk->path($path), basename($path), null, null, true);
                    $newPath = ImageOptimizer::store($file, dirname($path), $maxDimension);

                    if (! str_ends_with($newPath, '.webp') || ! $disk->exists($newPath)) {
                        if ($newPath !== $path) {
                            $disk->delete($newPath);
                        }
                        $this->line("  lewati (WebP tidak lebih kecil): {$path}");
                        continue;
                    }

                    DB::table($table)->where('id', $row->id)->update([$column => $newPath]);
                    $disk->delete($path);

                    $newSize = $disk->size($newPath);
                    $before += $size;
                    $after += $newSize;
                    $converted++;

                    $this->line(sprintf('  %-32s %6d KB -> %5d KB', "{$table}.{$column}", $size / 1024, $newSize / 1024));
                }
            }
        }

        if ($dryRun) {
            return self::SUCCESS;
        }

        PublicCache::flush();
        SiteSetting::flushCurrentCache();

        $this->info(sprintf(
            '%d gambar dioptimasi: %.1f MB -> %.1f MB',
            $converted,
            $before / 1024 / 1024,
            $after / 1024 / 1024
        ));

        return self::SUCCESS;
    }
}
