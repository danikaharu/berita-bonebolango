<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $slug = \Str::slug($title);

        return [
            'user_id' => 1,
            'category_id' => $this->faker->numberBetween(1, 3),
            'title' => $title,
            'slug' => $slug,
            'body' => $this->faker->paragraph,
            'caption' => 'Contoh caption',
            'thumbnail' => 'https://picsum.photos/1200/630',
            'status' => 'Published',
            'published_at' => Carbon::now(),
        ];
    }
}
