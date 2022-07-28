<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Album extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['user_id', 'title', 'slug', 'body'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['title' => CleanHtml::class, 'slug' => CleanHtml::class, 'body' => CleanHtml::class, 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function galleries()
    {
        return $this->hasMany(\App\Models\Gallery::class);
    }

    public function thumbnail()
    {
        return $this->galleries()->first();
    }
}
