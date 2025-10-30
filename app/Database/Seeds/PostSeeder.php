<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\PostCategoryModel;
use App\Models\UserModel;
use Faker\Factory;

class PostSeeder extends Seeder
{
    public function run()
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $postCategoryModel = new PostCategoryModel();
        $userModel = new UserModel();
        $faker = Factory::create();

        // Get the "Program Prioritas" parent category
        $parentCategory = $categoryModel->where('slug', 'program-prioritas')->first();

        if (empty($parentCategory)) {
            echo "Please run the CategorySeeder first to create the 'Program Prioritas' category.\n";
            return;
        }

        // Get the child categories of "Program Prioritas"
        $childCategories = $categoryModel->where('parent_id', $parentCategory['id'])->findAll();

        if (empty($childCategories)) {
            echo "Please create some child categories for 'Program Prioritas' first.\n";
            return;
        }

        $users = $userModel->findAll();

        if (empty($users)) {
            echo "Please create some users first.\n";
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $title = $faker->sentence();
            $postData = [
                'title' => $title,
                'slug' => url_title($title, '-', true),
                'content' => $faker->paragraphs(10, true),
                'status' => 'published',
                'user_id' => $faker->randomElement($users)['id'],
                'published_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'thumbnail' => 'https://picsum.photos/seed/' . $faker->uuid . '/800/600',
            ];

            $postId = $postModel->insert($postData);

            if ($postId) {
                // Assign a random child category
                $randomChildCategory = $faker->randomElement($childCategories);
                $postCategoryModel->insert([
                    'post_id' => $postId,
                    'category_id' => $randomChildCategory['id'],
                ]);
            }
        }
    }
}