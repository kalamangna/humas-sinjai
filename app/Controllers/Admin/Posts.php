<?php

namespace App\Controllers\Admin;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\PostCategoryModel;
use App\Models\PostTagModel;
use App\Models\UserModel;

class Posts extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $userModel = new UserModel();

        // Get filters from request
        $filters = [
            'search'   => $this->request->getGet('search'),
            'category' => $this->request->getGet('category'),
            'author'   => $this->request->getGet('author'),
        ];

        // Base query for filtering
        $builder = $postModel
            ->select('posts.*, users.name as author_name, GROUP_CONCAT(DISTINCT categories.name) as category_name, COUNT(DISTINCT post_tags.tag_id) as tag_count')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->join('post_categories', 'post_categories.post_id = posts.id', 'left')
            ->join('categories', 'categories.id = post_categories.category_id', 'left')
            ->join('post_tags', 'post_tags.post_id = posts.id', 'left')
            ->groupBy('posts.id, users.name');

        // Apply filters
        if (!empty($filters['search'])) {
            $builder->like('posts.title', $filters['search']);
        }
        if (!empty($filters['category'])) {
            $builder->whereIn('posts.id', function ($subquery) use ($filters) {
                $subquery->select('post_id')->from('post_categories')->where('category_id', $filters['category']);
            });
        }
        if (!empty($filters['author'])) {
            $builder->where('posts.user_id', $filters['author']);
        }

        $data = [
            'posts'           => $builder->orderBy('posts.published_at', 'DESC')->paginate(10, 'posts'),
            'pager'           => $postModel->pager,
            'filters'         => $filters,
            'categories'      => $categoryModel->findAll(),
            'users'           => $userModel->findAll(),
            // Stats for the top cards (unfiltered)
            'total_posts'     => (new PostModel())->countAllResults(),
            'published_posts' => (new PostModel())->where('status', 'published')->countAllResults(),
            'draft_posts'     => (new PostModel())->where('status', 'draft')->countAllResults(),
            'today_posts'     => (new PostModel())->where('DATE(created_at)', date('Y-m-d'))->countAllResults(),
        ];

        return $this->render('Admin/Posts/index', $data);
    }

    public function new()
    {
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['tags'] = $tagModel->orderBy('name', 'ASC')->findAll();
        return $this->render('Admin/Posts/new', $data);
    }

    public function create()
    {
        $validationRules = [
            'title'      => 'required|min_length[3]|max_length[255]',
            'content'    => 'required',
            'categories' => 'required',
            'tags'       => 'required',
            'status'     => 'required',
            'thumbnail'  => 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postModel = new PostModel();
        $postCategoryModel = new PostCategoryModel();
        $postTagModel = new PostTagModel();

        // Handle file upload
        $file = $this->request->getFile('thumbnail');
        $thumbnailName = null;
        if ($file->isValid() && ! $file->hasMoved()) {
            $thumbnailName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/thumbnails', $thumbnailName);
            $thumbnailName = base_url('uploads/thumbnails/' . $thumbnailName);
        }

        $postData = [
            'title'        => $this->request->getPost('title'),
            'slug'         => url_title($this->request->getPost('title'), '-', true),
            // TODO: Sanitize HTML content before saving to the database to prevent XSS attacks.
            'content'      => $this->request->getPost('content'),
            'status'       => $this->request->getPost('status'),
            'user_id'      => session()->get('user_id'),
            'published_at' => date('Y-m-d H:i:s'),
            'thumbnail'    => $thumbnailName,
            'thumbnail_caption' => $this->request->getPost('thumbnail_caption'),
        ];

        if ($postModel->save($postData)) {
            $postId = $postModel->getInsertID();

            // Sync categories
            $categoryIds = $this->request->getPost('categories') ?? [];
            if (! empty($categoryIds)) {
                $catsToInsert = [];
                foreach ($categoryIds as $catId) {
                    $catsToInsert[] = ['post_id' => $postId, 'category_id' => $catId];
                }
                $postCategoryModel->insertBatch($catsToInsert);
            }

            // Sync tags
            $tagIds = $this->request->getPost('tags') ?? [];
            if (! empty($tagIds)) {
                $tagsToInsert = [];
                foreach ($tagIds as $tagId) {
                    $tagsToInsert[] = ['post_id' => $postId, 'tag_id' => $tagId];
                }
                $postTagModel->insertBatch($tagsToInsert);
            }

            return redirect()->to(base_url('admin/posts'))->with('message', 'Post created successfully.');
        }

        return redirect()->back()->withInput()->with('errors', $postModel->errors());
    }

    public function edit($id = null)
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $postCategoryModel = new PostCategoryModel();

        $data['post'] = $postModel->find($id);
        if (empty($data['post'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the post: ' . $id);
        }
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['tags'] = $tagModel->orderBy('name', 'ASC')->findAll();
        $data['post_categories'] = array_column($postCategoryModel->where('post_id', $id)->findAll(), 'category_id');
        $data['post_tags'] = array_column($tagModel->select('tags.id')->join('post_tags', 'post_tags.tag_id = tags.id')->where('post_tags.post_id', $id)->findAll(), 'id');

        return $this->render('Admin/Posts/edit', $data);
    }

    public function update($id = null)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        $validationRules = [
            'title'      => 'required|min_length[3]|max_length[255]',
            'content'    => 'required',
            'categories' => 'required',
            'tags'       => 'required',
            'status'     => 'required',
        ];

        if ($this->request->getFile('thumbnail')->getName() !== '') {
            $validationRules['thumbnail'] = 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postCategoryModel = new PostCategoryModel();
        $postTagModel = new PostTagModel();

        $postData = [
            'title'   => $this->request->getPost('title'),
            'slug'    => url_title($this->request->getPost('title'), '-', true),
            // TODO: Sanitize HTML content before saving to the database to prevent XSS attacks.
            'content' => $this->request->getPost('content'),
            'status'  => $this->request->getPost('status'),
            'user_id' => session()->get('user_id'),
            'thumbnail_caption' => $this->request->getPost('thumbnail_caption'),
        ];

        // Handle file upload
        $file = $this->request->getFile('thumbnail');
        if ($file->isValid() && ! $file->hasMoved()) {
            // Delete old thumbnail if it exists
            if (! empty($post['thumbnail']) && file_exists(FCPATH . ltrim($post['thumbnail'], '/'))) {
                unlink(FCPATH . ltrim($post['thumbnail'], '/'));
            }

            $thumbnailName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/thumbnails', $thumbnailName);
            $postData['thumbnail'] = base_url('uploads/thumbnails/' . $thumbnailName);
        }

        if ($postModel->update($id, $postData)) {
            // Sync categories
            $categoryIds = $this->request->getPost('categories') ?? [];
            $postCategoryModel->where('post_id', $id)->delete();
            if (! empty($categoryIds)) {
                $catsToInsert = [];
                foreach ($categoryIds as $catId) {
                    $catsToInsert[] = ['post_id' => $id, 'category_id' => $catId];
                }
                $postCategoryModel->insertBatch($catsToInsert);
            }

            // Sync tags
            $tagIds = $this->request->getPost('tags') ?? [];
            $postTagModel->where('post_id', $id)->delete();
            if (! empty($tagIds)) {
                $tagsToInsert = [];
                foreach ($tagIds as $tagId) {
                    $tagsToInsert[] = ['post_id' => $id, 'tag_id' => $tagId];
                }
                $postTagModel->insertBatch($tagsToInsert);
            }

            return redirect()->to(base_url('admin/posts'))->with('message', 'Post updated successfully.');
        }

        return redirect()->back()->withInput()->with('errors', $postModel->errors());
    }

    public function delete($id = null)
    {
        $postModel = new PostModel();
        if ($postModel->delete($id)) {
            return redirect()->to(base_url('admin/posts'))->with('message', 'Post deleted successfully.');
        }

        return redirect()->to(base_url('admin/posts'))->with('error', 'Error deleting post.');
    }
}
