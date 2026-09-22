<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use FlushesPublicCache;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount_percent',
        'features',
        'is_highlighted',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price'            => 'integer',
        'discount_percent' => 'integer',
        'is_highlighted'   => 'boolean',
        'is_active'        => 'boolean',
        'sort_order'       => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function getHasDiscountAttribute(): bool
    {
        return (bool) $this->discount_percent && $this->discount_percent > 0;
    }

    /**
     * Harga setelah dipotong diskon — dibulatkan ke ratusan terdekat biar
     * angkanya tidak aneh (mis. Rp414.000 bukan Rp414.500 dari 460000 * 0.9).
     */
    public function getDiscountedPriceAttribute(): int
    {
        if (! $this->has_discount) {
            return $this->price;
        }

        $discounted = $this->price * (100 - $this->discount_percent) / 100;

        return (int) (round($discounted / 100) * 100);
    }

    public function getPriceLabelAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    public function getDiscountedPriceLabelAttribute(): string
    {
        return 'Rp' . number_format($this->discounted_price, 0, ',', '.');
    }

    /**
     * Daftar fitur sebagai array — disimpan 1 baris per fitur di kolom
     * `features` (textarea di form admin), dipecah di sini pas ditampilkan.
     */
    public function getFeatureListAttribute(): array
    {
        if (! $this->features) {
            return [];
        }

        return collect(explode("\n", $this->features))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}