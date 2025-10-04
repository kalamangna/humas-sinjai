<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\TagModel; // Import the TagModel

class TagSeeder extends Seeder
{
    public function run()
    {
        $tagModel = new TagModel(); // Instantiate the model

        $tagsData = ['news', 'hot', 'trending', 'viral', 'popular'];

        foreach ($tagsData as $tagName) {
            $slug = url_title($tagName, '-', true);
            // Check if tag already exists by slug
            if ($tagModel->where('slug', $slug)->first() === null) {
                $tagModel->save([
                    'name' => $tagName,
                    'slug' => $slug,
                ]);
            }
        }
    }
}