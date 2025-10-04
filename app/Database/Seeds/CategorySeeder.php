<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use App\Models\CategoryModel; // Import the CategoryModel

class CategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $categoryModel = new CategoryModel(); // Instantiate the model

        for ($i = 0; $i < 5; $i++) {
            $name = $faker->unique()->word;
            $slug = strtolower(url_title($name, '-', true));

            // Check if category already exists by slug
            if ($categoryModel->where('slug', $slug)->first() === null) {
                $categoryModel->save([
                    'name' => $name,
                    'slug' => $slug,
                ]);
            }
        }
    }
}
