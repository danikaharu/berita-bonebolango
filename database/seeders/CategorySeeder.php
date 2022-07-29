<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Pemerintahan',
            'slug' => Str::slug('Pemerintahan'),
            'description' => 'Kategori Berita Pemerintahan',
        ]);
        Category::create([
            'title' => 'Ekonomi',
            'slug' => Str::slug('Ekonomi'),
            'description' => 'Kategori Berita Ekonomi',
        ]);
        Category::create([
            'title' => 'Pembangunan',
            'slug' => Str::slug('Pembangunan'),
            'description' => 'Kategori Berita Pembangunan',
        ]);
        Category::create([
            'title' => 'Nasional',
            'slug' => Str::slug('Nasional'),
            'description' => 'Kategori Berita Nasional',
        ]);
        Category::create([
            'title' => 'Daerah',
            'slug' => Str::slug('Daerah'),
            'description' => 'Kategori Berita Daerah',
        ]);
        Category::create([
            'title' => 'DPRD',
            'slug' => Str::slug('DPRD'),
            'description' => 'Kategori Berita DPRD',
        ]);
        Category::create([
            'title' => 'BUMD',
            'slug' => Str::slug('BUMD'),
            'description' => 'Kategori Berita BUMD',
        ]);
    }
}
