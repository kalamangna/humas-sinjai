<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\PostCategoryModel;
use App\Models\UserModel;
use Faker\Factory;

class DummyPostSeeder extends Seeder
{
    public function run()
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $postCategoryModel = new PostCategoryModel();
        $userModel = new UserModel();
        $faker = Factory::create();

        $categories = $categoryModel->findAll();
        $users = $userModel->findAll();

        if (empty($categories) || empty($users)) {
            echo "Please create some categories and users first.\n";
            return;
        }

        for ($i = 0; $i < 50; $i++) {
            $title = $faker->sentence();
            $postData = [
                'title' => $title,
                'slug' => url_title($title, '-', true),
                'content' => $faker->paragraphs(5, true),
                'status' => 'published',
                'user_id' => $faker->randomElement($users)['id'],
                'published_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];

            $postId = $postModel->insert($postData);

            if ($postId) {
                $randomCategories = $faker->randomElements($categories, $faker->numberBetween(1, 3));
                foreach ($randomCategories as $category) {
                    $postCategoryModel->insert([
                        'post_id' => $postId,
                        'category_id' => $category['id'],
                    ]);
                }
            }
        }
    }
}
