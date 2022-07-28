<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Article extends Model
{
    use HasFactory;
    use \Conner\Tagging\Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'body', 'thumbnail', 'caption', 'status', 'published_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['title' => CleanHtml::class, 'body' => CleanHtml::class, 'thumbnail' => CleanHtml::class, 'caption' => CleanHtml::class, 'published_at' => 'datetime:d/m/Y H:i', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    protected $dates = ['published_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    public function scopeWhereCategory($query, $value)
    {
        return $query->where('category_id', $value);
    }
}
