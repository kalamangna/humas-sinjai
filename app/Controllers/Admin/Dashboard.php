<?php

namespace App\Controllers\Admin;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();

        $lastPost = $postModel->orderBy('published_at', 'DESC')->first();

        $data = [
            'postCount' => $this->data['total_posts'], // Use data from BaseController
            'categoryCount' => $this->data['total_categories'],
            'tagCount' => $this->data['total_tags'],
            'userCount' => (new UserModel())->countAllResults(),
            'recentPosts' => $postModel
                ->select('posts.title, posts.published_at, categories.name as category_name, users.name as author_name')
                ->join('users', 'users.id = posts.user_id', 'left')
                ->join('post_categories', 'post_categories.post_id = posts.id', 'left')
                ->join('categories', 'categories.id = post_categories.category_id', 'left')
                ->groupBy('posts.id, users.name')
                ->orderBy('posts.published_at', 'DESC')
                ->limit(5)
                ->findAll(),
            'lastPostUpdate' => $lastPost ? format_date($lastPost['published_at']) : 'N/A',
        ];

        return $this->render('Admin/Dashboard/index', $data);
    }
}