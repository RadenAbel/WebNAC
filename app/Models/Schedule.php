<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Schedule extends Model
{
    use HasFactory, FlushesPublicCache;

    protected $fillable = [
        'category',
        'days',
        'time_start',
        'time_end',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'days'       => 'array',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getDaysLabelAttribute(): string
    {
        return implode(', ', $this->days ?? []);
    }

    public function getTimeLabelAttribute(): string
    {
        $start = $this->time_start ? substr($this->time_start, 0, 5) : '';
        $end   = $this->time_end ? substr($this->time_end, 0, 5) : '';
        return str_replace(':', '.', $start) . ' – ' . str_replace(':', '.', $end);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
