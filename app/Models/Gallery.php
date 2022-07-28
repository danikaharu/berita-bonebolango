<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Gallery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['album_id', 'file', 'caption'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['file' => CleanHtml::class, 'caption' => CleanHtml::class, 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function album()
    {
        return $this->belongsTo(\App\Models\Album::class);
    }
}
