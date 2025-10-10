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

        // Create 5 parent categories
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->unique()->word;
            $slug = strtolower(url_title($name, '-', true));

            if ($categoryModel->where('slug', $slug)->first() === null) {
                $categoryModel->save([
                    'name' => $name,
                    'slug' => $slug,
                ]);

                $parentId = $categoryModel->getInsertID();

                // Create 2 subcategories for each parent
                for ($j = 0; $j < 2; $j++) {
                    $name = $faker->unique()->word;
                    $slug = strtolower(url_title($name, '-', true));

                    if ($categoryModel->where('slug', $slug)->first() === null) {
                        $categoryModel->save([
                            'name' => $name,
                            'slug' => $slug,
                            'parent_id' => $parentId,
                        ]);
                    }
                }
            }
        }
    }
}
