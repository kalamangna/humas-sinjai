<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PostModel;

class RemovePostsWithoutThumbnailsSeeder extends Seeder
{
    public function run()
    {
        $postModel = new PostModel();

        // Find posts with NULL or empty thumbnail
        $postsToDelete = $postModel->where('thumbnail IS NULL')->orWhere('thumbnail', '')->findAll();

        if (!empty($postsToDelete)) {
            $idsToDelete = array_column($postsToDelete, 'id');
            $postModel->delete($idsToDelete);
            echo "Deleted " . count($idsToDelete) . " posts without thumbnails.\n";
        } else {
            echo "No posts without thumbnails found.\n";
        }
    }
}