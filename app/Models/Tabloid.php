<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Tabloid extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['user_id', 'title', 'slug', 'type', 'thumbnail', 'file'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['title' => CleanHtml::class, 'slug' => CleanHtml::class, 'thumbnail' => CleanHtml::class, 'file' => CleanHtml::class, 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeTypeTabloid($query, $value)
    {
        return $query->where('type', $value)
            ->select('thumbnail', 'slug')
            ->latest()
            ->take(12)
            ->simplePaginate(6);
    }
}
