<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController as AppBaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BaseController extends AppBaseController
{
    protected $data = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['image']);

        // Temporarily disable ONLY_FULL_GROUP_BY for debugging
        $this->db = \Config\Database::connect();
        $this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

        // Preload models and data for all admin pages
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $userModel = new UserModel();

        $this->data = [
            'total_posts' => $postModel->countAllResults(),
            'total_categories' => $categoryModel->countAllResults(),
            'total_tags' => $tagModel->countAllResults(),
            'total_users' => $userModel->countAllResults(),
            'current_user' => session()->get(),
        ];
    }

    /**
     * Custom render method to automatically pass shared data to views.
     */
    protected function render(string $view, array $data = [])
    {
        return view($view, array_merge($this->data, $data));
    }
}
