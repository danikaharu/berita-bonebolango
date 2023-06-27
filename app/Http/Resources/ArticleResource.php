<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Analytics;
use Spatie\Analytics\Period;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $urlThumbnail = 'https://berita.bonebolangokab.go.id/storage/uploads/articles/' . $this->thumbnail;

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category->title,
            'published_at' => $this->published_at->isoFormat('D MMMM Y'),
            'thumbnail' => $urlThumbnail,
            'caption' =>   $this->caption,
            'body' => $this->body,
            'author' => $this->user->name,
            'tag' => $this->tagNames(),
            'url' => 'https://berita.bonebolangokab.go.id/berita/' . $this->slug,
        ];
    }
}
