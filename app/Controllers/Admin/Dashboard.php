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
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $userModel = new UserModel();

        $lastPost = $postModel->orderBy('published_at', 'DESC')->first();
        $totalViews = $postModel->selectSum('views')->first()['views'];
        $popularPosts = $postModel->orderBy('views', 'DESC')->limit(5)->findAll();

        $data = [
            'postCount' => $postModel->countAllResults(),
            'categoryCount' => $categoryModel->countAllResults(),
            'tagCount' => $tagModel->countAllResults(),
            'userCount' => $userModel->countAllResults(),
            'totalViews' => $totalViews,
            'popularPosts' => $popularPosts,
            'recentPosts' => $postModel
                ->select('posts.title, posts.published_at, users.name as author_name')
                ->join('users', 'users.id = posts.user_id', 'left')
                ->orderBy('posts.published_at', 'DESC')
                ->limit(5)
                ->findAll(),
            'lastPostUpdate' => $lastPost ? format_date($lastPost['published_at']) : 'N/A',
        ];

        return $this->render('Admin/Dashboard/index', $data);
    }
}