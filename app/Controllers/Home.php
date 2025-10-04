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

        $data['title'] = $data['post']['title'];

        // Tags are now part of the post data
        $data['tags'] = $data['post']['tags'];

        // Fetch recent posts, excluding the current one
        $data['recent_posts'] = $postModel->where('id !=', $data['post']['id'])->orderBy('published_at', 'DESC')->limit(5)->findAll();

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
        ];

        return view('posts', $data);
    }

    public function categories()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'categories' => $categoryModel
                ->select('categories.*, COUNT(post_categories.post_id) as post_count')
                ->join('post_categories', 'post_categories.category_id = categories.id', 'left')
                ->groupBy('categories.id')
                ->orderBy('categories.name', 'ASC')
                ->findAll(),
            'title' => 'Semua Kategori',
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
        ];

        return view('tags', $data);
    }
}
