<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PostSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $postModel = new \App\Models\PostModel();
        $categoryModel = new \App\Models\CategoryModel();
        $postCategoryModel = new \App\Models\PostCategoryModel();
        $userModel = new \App\Models\UserModel();

        // Get all category and user IDs
        $categoryIds = array_column($categoryModel->select('id')->findAll(), 'id');
        $userIds = array_column($userModel->select('id')->findAll(), 'id');

        for ($i = 0; $i < 30; $i++) {
            $title = $faker->sentence();

            // 1. Create the post
            $postData = [
                'title'       => $title,
                'slug'        => strtolower(url_title($title, '-', true)),
                'content'     => $faker->paragraphs(3, true),
                'thumbnail'   => 'https://picsum.photos/seed/' . uniqid() . '/800/400',
                'thumbnail_caption' => $faker->sentence(),
                'status'      => 'published',
                'user_id'     => $faker->randomElement($userIds), // Assign a random user
                'published_at' => $faker->dateTimeThisYear()->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i:s'),
            ];
            $postModel->save($postData);

            // 2. Get the new post ID
            $postId = $postModel->getInsertID();

            // 3. Associate categories
            $numCategories = $faker->numberBetween(1, 3);
            $shuffledCatIds = $faker->randomElements($categoryIds, $numCategories);

            $catsToInsert = [];
            foreach ($shuffledCatIds as $catId) {
                $catsToInsert[] = ['post_id' => $postId, 'category_id' => $catId];
            }
            $postCategoryModel->insertBatch($catsToInsert);
        }
    }
}
