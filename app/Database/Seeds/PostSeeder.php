<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostCategoryModel;
use App\Models\PostTagModel;
use App\Models\UserModel;
use Faker\Factory;

class PostSeeder extends Seeder
{
    public function run()
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $postCategoryModel = new PostCategoryModel();
        $postTagModel = new PostTagModel();
        $userModel = new UserModel();
        $faker = Factory::create();

        $categories = $categoryModel->findAll();
        $tags = $tagModel->findAll();
        $users = $userModel->findAll();

        if (empty($categories) || empty($tags) || empty($users)) {
            echo "Please create some categories, tags, and users first.\n";
            return;
        }

        for ($i = 0; $i < 50; $i++) {
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
                // Assign categories
                $randomCategories = $faker->randomElements($categories, $faker->numberBetween(1, 3));
                foreach ($randomCategories as $category) {
                    $postCategoryModel->insert([
                        'post_id' => $postId,
                        'category_id' => $category['id'],
                    ]);
                }

                // Assign tags
                $randomTags = $faker->randomElements($tags, $faker->numberBetween(2, 5));
                foreach ($randomTags as $tag) {
                    $postTagModel->insert([
                        'post_id' => $postId,
                        'tag_id' => $tag['id'],
                    ]);
                }
            }
        }
    }
}
