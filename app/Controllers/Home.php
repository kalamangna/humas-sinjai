<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostCategoryModel;

class Home extends BaseController
{
    public function index(): string
    {
        $postModel = new PostModel();
        $posts = $postModel->getPosts(); // Get basic post data
        $data['posts'] = $postModel->withCategoriesAndTags($posts); // Enrich with categories and tags

        return view('home', $data);
    }

    public function post($slug = null)
    {
        $postModel = new PostModel();
        $post = $postModel->getPosts(['slug' => $slug]); // Get basic post data

        if (empty($post)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the post: ' . $slug);
        }

        // Enrich with categories and tags
        $enrichedPost = $postModel->withCategoriesAndTags([$post]);
        $data['post'] = $enrichedPost[0]; // Get the single enriched post

        $postModel->incrementViews($data['post']['id']);

        $data['title'] = $data['post']['title'];
        $data['description'] = substr(strip_tags($data['post']['content']), 0, 160);
        $data['keywords'] = implode(', ', array_column($data['post']['tags'], 'name'));
        $data['image'] = !empty($data['post']['thumbnail']) ? $data['post']['thumbnail'] : base_url('meta.png');


        // Tags are now part of the post data
        $data['tags'] = $data['post']['tags'];

        // Fetch recent posts
        $data['recent_posts'] = $postModel->orderBy('published_at', 'DESC')->limit(5)->findAll();

        // Fetch popular posts
        $data['popular_posts'] = $postModel->orderBy('views', 'DESC')->limit(5)->findAll();

        // Fetch related posts
        $categoryIds = array_column($data['post']['categories'], 'id');
        $tagIds = array_column($data['post']['tags'], 'id');

        $relatedPosts = [];
        if (!empty($categoryIds) || !empty($tagIds)) {
            $builder = $postModel->where('posts.id !=', $data['post']['id']);

            $builder->groupStart();
            if (!empty($categoryIds)) {
                $builder->whereIn('posts.id', function ($subquery) use ($categoryIds) {
                    $subquery->select('post_id')->from('post_categories')->whereIn('category_id', $categoryIds);
                });
            }
            if (!empty($tagIds)) {
                $builder->orWhereIn('posts.id', function ($subquery) use ($tagIds) {
                    $subquery->select('post_id')->from('post_tags')->whereIn('tag_id', $tagIds);
                });
            }
            $builder->groupEnd();

            $relatedPosts = $builder->orderBy('published_at', 'DESC')->limit(5)->findAll();
        }

        $data['related_posts'] = $postModel->withCategoriesAndTags($relatedPosts);

        return view('post_detail', $data);
    }

    public function category($slug)
    {
        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->where('slug', $slug)->first();

        if (empty($data['category'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the category: ' . $slug);
        }

        // 1. Get post IDs for the current category
        $postCategoryModel = new PostCategoryModel();
        $postIds = array_column($postCategoryModel->where('category_id', $data['category']['id'])->findAll(), 'post_id');

        $postModel = new PostModel();
        $data['posts'] = [];
        $data['pager'] = null;

        if (!empty($postIds)) {
            // 2. Fetch those posts and all their associated categories
            $posts = $postModel->whereIn('posts.id', $postIds)->orderBy('posts.published_at', 'DESC')->paginate(10);
            $data['posts'] = $postModel->withCategoriesAndTags($posts);
            $data['pager'] = $postModel->pager;
        }

        $data['title'] = 'Kategori: ' . $data['category']['name'];
        $data['description'] = 'Telusuri semua berita dalam kategori ' . $data['category']['name'] . ' di Humas Sinjai.';
        $data['keywords'] = 'Humas Sinjai, Berita Sinjai, ' . $data['category']['name'];

        return view('category_detail', $data);
    }

    public function tag($slug)
    {
        $tagModel = new TagModel();
        $data['tag'] = $tagModel->where('slug', $slug)->first();

        if (empty($data['tag'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the tag: ' . $slug);
        }

        // 1. Get post IDs for the current tag
        $postTagModel = new \App\Models\PostTagModel();
        $postIds = array_column($postTagModel->where('tag_id', $data['tag']['id'])->findAll(), 'post_id');

        $postModel = new PostModel();
        $data['posts'] = [];
        $data['pager'] = null;

        if (!empty($postIds)) {
            // 2. Fetch those posts and all their associated categories
            $posts = $postModel->whereIn('posts.id', $postIds)->orderBy('posts.published_at', 'DESC')->paginate(10);
            $data['posts'] = $postModel->withCategoriesAndTags($posts);
            $data['pager'] = $postModel->pager;
        }

        $data['title'] = 'Tag: ' . $data['tag']['name'];
        $data['description'] = 'Telusuri semua berita dengan tag ' . $data['tag']['name'] . ' di Humas Sinjai.';
        $data['keywords'] = 'Humas Sinjai, Berita Sinjai, ' . $data['tag']['name'];

        return view('tag_detail', $data);
    }

    public function search()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'q' => 'required|min_length[3]',
        ], [
            'q' => [
                'required' => 'Silakan masukkan kata kunci pencarian.',
                'min_length' => 'Kata kunci pencarian minimal harus 3 karakter.',
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors()['q']);
        }

        $postModel = new PostModel();
        $query = $this->request->getGet('q');
        $posts = $postModel->like('title', $query)->orLike('content', $query)->orderBy('posts.published_at', 'DESC')->findAll();
        $data = [
            'posts' => $postModel->withCategoriesAndTags($posts),
            'query' => $query,
            'title' => 'Hasil pencarian untuk: ' . $query,
            'description' => 'Hasil pencarian untuk kata kunci ' . $query . ' di Humas Sinjai.',
            'keywords' => 'pencarian, ' . $query,
        ];

        return view('search_results', $data);
    }

    public function posts()
    {
        $postModel = new PostModel();
        $posts = $postModel->getPosts(false, true, 10); // Get paginated basic post data
        $data = [
            'posts' => $postModel->withCategoriesAndTags($posts),
            'pager' => $postModel->pager,
            'title' => 'Semua Berita',
            'description' => 'Telusuri semua berita terbaru dari Humas Sinjai.',
            'keywords' => 'berita, humas sinjai, sinjai, berita terbaru',
        ];

        return view('posts', $data);
    }

    public function categories()
    {
        $categoryModel = new CategoryModel();
        $allCategories = $categoryModel
            ->select('categories.*, COUNT(post_categories.post_id) as post_count')
            ->join('post_categories', 'post_categories.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->orderBy('categories.name', 'ASC')
            ->findAll();

        $categories = [];
        $subCategories = [];

        foreach ($allCategories as $category) {
            if ($category['parent_id'] === null) {
                $categories[] = $category;
            } else {
                $subCategories[$category['parent_id']][] = $category;
            }
        }

        $data = [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'title' => 'Semua Kategori',
            'description' => 'Telusuri semua kategori berita di Humas Sinjai.',
            'keywords' => 'kategori, berita, humas sinjai, sinjai',
        ];

        return view('categories', $data);
    }

    public function tags()
    {
        $tagModel = new TagModel();
        $data = [
            'tags' => $tagModel
                ->select('tags.*, COUNT(post_tags.post_id) as post_count')
                ->join('post_tags', 'post_tags.tag_id = tags.id', 'left')
                ->groupBy('tags.id')
                ->orderBy('tags.name', 'ASC')
                ->findAll(),
            'title' => 'Semua Tag',
            'description' => 'Telusuri semua tag berita di Humas Sinjai.',
            'keywords' => 'tag, berita, humas sinjai, sinjai',
        ];

        return view('tags', $data);
    }

    public function rss()
    {
        $postModel = new PostModel();
        $posts = $postModel->orderBy('published_at', 'DESC')->limit(20)->findAll();

        $this->response->setHeader('Content-Type', 'application/rss+xml');

        $data = [
            'posts' => $posts,
        ];

        return view('rss', $data);
    }
}
