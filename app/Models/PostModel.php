<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'content', 'thumbnail', 'thumbnail_caption', 'status', 'user_id', 'published_at'];
    protected $useTimestamps = true;

    // New methods for fetching related data
    public function getPostCategories(int $postId)
    {
        $postCategoryModel = new \App\Models\PostCategoryModel();
        return $postCategoryModel
            ->select('categories.id, categories.name, categories.slug')
            ->join('categories', 'categories.id = post_categories.category_id')
            ->where('post_id', $postId)
            ->findAll();
    }

    public function getPostTags(int $postId)
    {
        $postTagModel = new \App\Models\PostTagModel();
        return $postTagModel
            ->select('tags.id, tags.name, tags.slug')
            ->join('tags', 'tags.id = post_tags.tag_id')
            ->where('post_id', $postId)
            ->findAll();
    }

    public function withCategoriesAndTags(array $posts)
    {
        foreach ($posts as &$post) {
            $post['categories'] = $this->getPostCategories($post['id']);
            $post['tags'] = $this->getPostTags($post['id']);
        }
        return $posts;
    }

    public function getPosts($slug = false, $paginate = false, $publishedOnly = true)
    {
        $builder = $this->select('posts.*, users.name as author_name')
            ->join('users', 'users.id = posts.user_id', 'left');

        if ($publishedOnly) {
            $builder->where('posts.status', 'published');
        }

        if ($slug === false) {
            $posts = $paginate
                ? $builder->orderBy('posts.published_at', 'DESC')->paginate(10)
                : $builder->orderBy('posts.published_at', 'DESC')->findAll();

            // Tambahkan data views dari Google Analytics
            return $this->addGAData($posts);
        }

        $post = $builder->where(['posts.slug' => $slug])->first();

        // Tambahkan data views dari Google Analytics untuk single post
        if ($post) {
            $postsWithGA = $this->addGAData([$post]);
            return $postsWithGA[0] ?? $post;
        }

        return $post;
    }

    /**
     * Menambahkan data views dari Google Analytics ke array posts
     */
    private function addGAData(array $posts): array
    {
        if (empty($posts)) {
            return $posts;
        }

        // Ambil semua slug dari posts
        $slugs = array_column($posts, 'slug');

        // Dapatkan views dari Google Analytics
        $gaModel = new \App\Models\GoogleAnalyticsModel();
        $viewsData = $gaModel->getViewsBySlug($slugs);

        // Tambahkan views data ke setiap post
        foreach ($posts as &$post) {
            $post['views'] = $viewsData[$post['slug']] ?? 0;
        }

        return $posts;
    }

    // Method incrementViews dihapus karena sudah menggunakan data dari GA
}
