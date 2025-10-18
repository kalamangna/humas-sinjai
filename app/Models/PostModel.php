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
            // Pastikan post memiliki id sebelum memanggil method terkait
            if (isset($post['id'])) {
                $post['categories'] = $this->getPostCategories($post['id']);
                $post['tags'] = $this->getPostTags($post['id']);
            } else {
                // Fallback jika id tidak ada
                $post['categories'] = [];
                $post['tags'] = [];
            }
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

    // Method untuk mendapatkan popular posts dengan GA views
    public function getPopularPosts()
    {
        // Ambil semua posts yang published
        $posts = $this->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->findAll();

        // Tambahkan data GA views
        $postsWithGA = $this->addGAData($posts);

        // Urutkan berdasarkan views dari GA (descending)
        usort($postsWithGA, function ($a, $b) {
            return ($b['views'] ?? 0) - ($a['views'] ?? 0);
        });

        // Ambil 5 data teratas
        return array_slice($postsWithGA, 0, 5);
    }

    // Method untuk mendapatkan recent posts dengan GA views
    public function getRecentPosts()
    {
        $posts = $this->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->findAll(5); // Ambil 5 post terbaru

        return $this->addGAData($posts);
    }
}
