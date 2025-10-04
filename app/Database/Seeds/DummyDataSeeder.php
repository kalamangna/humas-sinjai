<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $this->db->disableForeignKeyChecks();

        $this->db->table('post_tags')->truncate();
        $this->db->table('posts')->truncate();
        $this->db->table('categories')->truncate();
        $this->db->table('users')->truncate();
        $this->db->table('tags')->truncate();

        $this->db->enableForeignKeyChecks();

        // Create Categories
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->word;
            $categories[] = [
                'name' => $name,
                'slug' => strtolower($name),
            ];
        }
        $this->db->table('categories')->insertBatch($categories);

        // Create Users
        $users = [
            [
                'name'     => 'Admin User',
                'email'    => 'admin@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Author User',
                'email'    => 'author@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'author',
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // Create Tags
        $tags = [];
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->unique()->word;
            $tags[] = [
                'name' => $name,
                'slug' => strtolower($name),
            ];
        }
        $this->db->table('tags')->insertBatch($tags);

        $this->db->table('post_tags')->truncate();
        $this->db->table('posts')->truncate();
        $this->db->table('categories')->truncate();
        $this->db->table('users')->truncate();
        $this->db->table('tags')->truncate();

        $faker->unique(true);

        // Create Posts
        $posts = [];
        for ($i = 0; $i < 10; $i++) {
            $title = $faker->sentence;
            $posts[] = [
                'title'       => $title,
                'slug'        => strtolower(str_replace(' ', '-', $title)),
                'content'     => $faker->paragraphs(3, true),
                'thumbnail'   => 'https://via.placeholder.com/350x150',
                'status'      => 'published',
                'user_id'     => $faker->numberBetween(1, 2),
                'category_id' => $faker->numberBetween(1, 5),
                'published_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('posts')->insertBatch($posts);

        // Create Post Tags
        $postTags = [];
        for ($i = 1; $i <= 10; $i++) {
            $tagCount = $faker->numberBetween(1, 3);
            $usedTags = [];
            for ($j = 0; $j < $tagCount; $j++) {
                $tagId = $faker->numberBetween(1, 10);
                if (!in_array($tagId, $usedTags)) {
                    $postTags[] = [
                        'post_id' => $i,
                        'tag_id'  => $tagId,
                    ];
                    $usedTags[] = $tagId;
                }
            }
        }
        $this->db->table('post_tags')->insertBatch($postTags);
    }
}
