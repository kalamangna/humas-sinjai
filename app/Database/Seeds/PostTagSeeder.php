<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PostTagSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $postTagModel = $db->table('post_tags');

        // Get all post and tag IDs
        $postModel = new \App\Models\PostModel();
        $tagModel = new \App\Models\TagModel();
        $posts = $postModel->findAll();
        $tags = $tagModel->findAll();

        if (empty($posts) || empty($tags)) {
            return;
        }

        foreach ($posts as $post) {
            // Assign 1 to 3 random tags to each post
            $randomTags = array_rand($tags, rand(1, 3));
            if (!is_array($randomTags)) {
                $randomTags = [$randomTags];
            }

            foreach ($randomTags as $tagIndex) {
                $postTagModel->insert([
                    'post_id' => $post['id'],
                    'tag_id' => $tags[$tagIndex]['id'],
                ]);
            }
        }
    }
}
