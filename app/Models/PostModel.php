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

    public function getPostsByMonthYear($month, $year)
    {
        $posts = $this->where('MONTH(published_at)', $month)
            ->where('YEAR(published_at)', $year)
            ->findAll();

        return $this->addGAData($posts);
    }

    public function getDistinctMonths()
    {
        return $this->select('YEAR(published_at) as year, MONTH(published_at) as month')
            ->distinct()
            ->orderBy('year', 'DESC')
            ->orderBy('month', 'DESC')
            ->findAll();
    }

    public function searchAndAddGAData(string $query): array
    {
        $posts = $this->where('status', 'published')
            ->like('title', $query)
            ->orLike('content', $query)
            ->orderBy('posts.published_at', 'DESC')
            ->findAll();

        return $this->addGAData($posts);
    }

    /**
     * Get related posts based on Tags, Categories, and Title/Content Similarity
     * 
     * @param array $currentPost The current post data (including tags/categories if available)
     * @param int $limit Number of related posts to return
     * @return array
     */
    public function getRelatedPosts(array $currentPost, int $limit = 6)
    {
        $currentPostId = $currentPost['id'];
        
        // 1. Prepare IDs
        $tagIds = [];
        if (!empty($currentPost['tags'])) {
            $tagIds = array_column($currentPost['tags'], 'id');
        }

        $categoryIds = [];
        if (!empty($currentPost['categories'])) {
            $categoryIds = array_column($currentPost['categories'], 'id');
        }
        
        // 2. Extract keywords from title for Full-Text Search
        $title = $currentPost['title'];
        // Simple stopword removal (Bahasa Indonesia + Common English)
        $stopwords = [
            'dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'pada', 'dengan', 'ini', 'itu', 'adalah', 
            'sebagai', 'dalam', 'atas', 'oleh', 'kepada', 'bisa', 'akan', 'atau', 'kami', 'kita',
            'mereka', 'dia', 'ia', 'juga', 'sudah', 'telah', 'bagi', 'namun', 'tetapi', 'sedangkan',
            'the', 'of', 'and', 'to', 'in', 'is', 'for', 'on', 'that', 'by', 'at', 'with'
        ];
        
        // Clean title: lowercase, alphanumeric + spaces only
        $cleanTitle = preg_replace('/[^a-z0-9\s]/', '', strtolower($title));
        $words = explode(' ', $cleanTitle);
        $keywords = array_diff($words, $stopwords);
        $keywords = array_filter($keywords, function($w) { return strlen($w) > 2; }); // Filter very short words
        $searchString = implode(' ', $keywords);
        $searchStringEscaped = $this->db->escapeString($searchString);
        
        // 3. Check if we have any criteria to search for
        if (empty($searchString) && empty($tagIds) && empty($categoryIds)) {
             // No criteria to match, just return recent posts excluding current
             return $this->where('posts.id !=', $currentPostId)
                         ->where('posts.status', 'published')
                         ->orderBy('published_at', 'DESC')
                         ->limit($limit)
                         ->findAll();
        }

        // 4. Build Query
        $builder = $this->select('posts.*');
        
        // --- Scoring Columns ---
        
        // Content Score (Full-Text) -> Weight: 1.5
        if (!empty($searchString)) {
            $builder->select("(MATCH(title, content) AGAINST('$searchStringEscaped')) * 1.5 AS content_score");
        } else {
            $builder->select("0 AS content_score");
        }

        // Tag Score -> Weight: 2 per matching tag
        if (!empty($tagIds)) {
            $tagIdsStr = implode(',', array_map('intval', $tagIds));
            $builder->select("(SELECT COUNT(*) FROM post_tags WHERE post_tags.post_id = posts.id AND post_tags.tag_id IN ($tagIdsStr)) * 2 AS tag_score");
        } else {
            $builder->select("0 AS tag_score");
        }

        // Category Score -> Weight: 1 per matching category
        if (!empty($categoryIds)) {
            $catIdsStr = implode(',', array_map('intval', $categoryIds));
            $builder->select("(SELECT COUNT(*) FROM post_categories WHERE post_categories.post_id = posts.id AND post_categories.category_id IN ($catIdsStr)) AS cat_score");
        } else {
            $builder->select("0 AS cat_score");
        }

        // --- Filtering ---
        $builder->where('posts.id !=', $currentPostId)
                ->where('posts.status', 'published');
        
        // Optimization: Only select posts that have SOME relevance
        $builder->groupStart();
            if (!empty($searchString)) {
                $builder->orWhere("MATCH(title, content) AGAINST('$searchStringEscaped') > 0");
            }
            if (!empty($tagIds)) {
                 $builder->orWhere("EXISTS (SELECT 1 FROM post_tags WHERE post_tags.post_id = posts.id AND post_tags.tag_id IN ($tagIdsStr))");
            }
            if (!empty($categoryIds)) {
                $builder->orWhere("EXISTS (SELECT 1 FROM post_categories WHERE post_categories.post_id = posts.id AND post_categories.category_id IN ($catIdsStr))");
            }
        $builder->groupEnd();
        
        // --- Ordering ---
        // Order by total score DESC, then recency
        $builder->orderBy('(content_score + tag_score + cat_score)', 'DESC');
        $builder->orderBy('published_at', 'DESC');
        
        $results = $builder->limit($limit)->findAll();
        
        // --- Fallback ---
        // If we don't have enough related posts, fill with recent posts
        if (count($results) < $limit) {
            $needed = $limit - count($results);
            $excludeIds = array_column($results, 'id');
            $excludeIds[] = $currentPostId;
            
            $fallbackBuilder = $this->db->table($this->table)
                                  ->select('posts.*, 0 AS content_score, 0 AS tag_score, 0 AS cat_score') // Align columns
                                  ->whereNotIn('id', $excludeIds)
                                  ->where('status', 'published')
                                  ->orderBy('published_at', 'DESC')
                                  ->limit($needed);
            
            $fallbackPosts = $fallbackBuilder->get()->getResultArray();             
            $results = array_merge($results, $fallbackPosts);
        }
        
        return $results;
    }
}
