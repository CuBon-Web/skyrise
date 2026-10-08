<?php

namespace App\models\website;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'title', 'slug', 'image', 'event_date', 'event_time', 'location', 'tag', 'content', 'status',
    ];

    protected $casts = [
        'event_date' => 'date:Y-m-d',
        'status' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Upcoming events first (nearest date), then past events (most recent first).
     */
    public function scopeHomeOrder($query)
    {
        $today = now()->toDateString();

        return $query
            ->orderByRaw('CASE WHEN event_date IS NULL THEN 2 WHEN event_date >= ? THEN 0 ELSE 1 END', [$today])
            ->orderByRaw('CASE WHEN event_date >= ? THEN event_date END ASC', [$today])
            ->orderBy('event_date', 'DESC')
            ->orderBy('id', 'DESC');
    }

    public static function uniqueSlug($title, $ignoreId = null)
    {
        $base = to_slug($title) ?: 'su-kien';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($ignoreId, function ($q) use ($ignoreId) {
            $q->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
