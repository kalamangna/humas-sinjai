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
            'status'   => $this->request->getGet('status'),
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
        if (!empty($filters['status'])) {
            $builder->where('posts.status', $filters['status']);
        }

        $data = [
            'posts'           => $builder->orderBy('posts.created_at', 'DESC')->paginate(10, 'posts'),
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

        $allCategories = $categoryModel->orderBy('name', 'ASC')->findAll();

        $categories = [];
        foreach ($allCategories as $category) {
            if ($category['parent_id'] === null) {
                $children = [];
                foreach ($allCategories as $subCategory) {
                    if ($subCategory['parent_id'] == $category['id']) {
                        $children[] = $subCategory;
                    }
                }
                $category['children'] = $children;
                $categories[] = $category;
            }
        }

        $data['categories'] = $categories;
        $data['tags'] = $tagModel->orderBy('name', 'ASC')->findAll();
        $data['post_categories'] = [];
        return $this->render('Admin/Posts/new', $data);
    }

    public function create()
    {
        $validationRules = [
            'title'      => 'required|min_length[3]|max_length[255]',
            'content'    => 'required',
            'categories' => 'required',
            'status'     => 'required',
        ];

        if (empty($this->request->getPost('pasted_thumbnail'))) {
            $validationRules['thumbnail'] = 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tags = $this->request->getPost('tags');
        $newTags = $this->request->getPost('new_tags');

        if (empty($tags) && empty($newTags)) {
            return redirect()->back()->withInput()->with('errors', ['tags' => 'The tags field is required.']);
        }

        $postModel = new PostModel();
        $postCategoryModel = new PostCategoryModel();
        $postTagModel = new PostTagModel();

        // Handle file upload
        $thumbnailName = null;
        $pastedThumbnail = $this->request->getPost('pasted_thumbnail');

        if (!empty($pastedThumbnail)) {
            list($type, $data) = explode(';', $pastedThumbnail);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $thumbnailName = uniqid() . '.png';
            file_put_contents(FCPATH . 'uploads/thumbnails/' . $thumbnailName, $data);
            $thumbnailName = base_url('uploads/thumbnails/' . $thumbnailName);
        } else {
            $file = $this->request->getFile('thumbnail');
            if ($file->isValid() && ! $file->hasMoved()) {
                $thumbnailName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/thumbnails', $thumbnailName);
                $thumbnailName = base_url('uploads/thumbnails/' . $thumbnailName);
            }
        }

        $status = $this->request->getPost('status');
        $postData = [
            'title'        => $this->request->getPost('title'),
            'slug'         => url_title($this->request->getPost('title'), '-', true),
            // TODO: Sanitize HTML content before saving to the database to prevent XSS attacks.
            'content'      => $this->request->getPost('content'),
            'status'       => $status,
            'user_id'      => session()->get('user_id'),
            'thumbnail'    => $thumbnailName,
            'thumbnail_caption' => $this->request->getPost('thumbnail_caption'),
        ];

        if ($status === 'published') {
            $postData['published_at'] = date('Y-m-d H:i:s');
        }

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
            $tags = $this->request->getPost('tags');
            $tagIds = [];
            if (!empty($tags)) {
                $tagModel = new TagModel();
                $tagNames = explode(',', $tags);
                foreach ($tagNames as $tagName) {
                    $tagName = trim($tagName);
                    if (empty($tagName)) continue;

                    $slug = url_title($tagName, '-', true);
                    $tag = $tagModel->where('slug', $slug)->first();
                    if (!$tag) {
                        $tagId = $tagModel->insert([
                            'name' => $tagName,
                            'slug' => $slug,
                        ]);
                        $tagIds[] = $tagId;
                    } else {
                        $tagIds[] = $tag['id'];
                    }
                }
            }

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

        $allCategories = $categoryModel->orderBy('name', 'ASC')->findAll();

        $categories = [];
        foreach ($allCategories as $category) {
            if ($category['parent_id'] === null) {
                $children = [];
                foreach ($allCategories as $subCategory) {
                    if ($subCategory['parent_id'] == $category['id']) {
                        $children[] = $subCategory;
                    }
                }
                $category['children'] = $children;
                $categories[] = $category;
            }
        }

        $data['categories'] = $categories;
        $data['tags'] = $tagModel->orderBy('name', 'ASC')->findAll();
        $data['post_categories'] = array_column($postCategoryModel->where('post_id', $id)->findAll(), 'category_id');

        $post_tags = $tagModel->select('tags.id, tags.name')->join('post_tags', 'post_tags.tag_id = tags.id')->where('post_tags.post_id', $id)->findAll();
        $data['post_tag_ids'] = array_column($post_tags, 'id');
        $data['post_tag_names'] = array_column($post_tags, 'name');

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
            'status'     => 'required',
        ];

        if ($this->request->getFile('thumbnail')->getName() !== '') {
            $validationRules['thumbnail'] = 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tags = $this->request->getPost('tags');
        $newTags = $this->request->getPost('new_tags');

        if (empty($tags) && empty($newTags)) {
            return redirect()->back()->withInput()->with('errors', ['tags' => 'The tags field is required.']);
        }

        $postCategoryModel = new PostCategoryModel();
        $postTagModel = new PostTagModel();

        $status = $this->request->getPost('status');
        $postData = [
            'title'   => $this->request->getPost('title'),
            'slug'    => url_title($this->request->getPost('title'), '-', true),
            // TODO: Sanitize HTML content before saving to the database to prevent XSS attacks.
            'content' => $this->request->getPost('content'),
            'status'  => $status,
            'user_id' => session()->get('user_id'),
            'thumbnail_caption' => $this->request->getPost('thumbnail_caption'),
        ];

        if ($status === 'published') {
            if ($this->request->getPost('published_at')) {
                $postData['published_at'] = $this->request->getPost('published_at');
            } elseif (empty($post['published_at'])) {
                $postData['published_at'] = date('Y-m-d H:i:s');
            }
        } else {
            $postData['published_at'] = null;
        }

        // Handle file upload
        $pastedThumbnail = $this->request->getPost('pasted_thumbnail');
        if (!empty($pastedThumbnail)) {
            // Delete old thumbnail if it exists
            if (! empty($post['thumbnail']) && file_exists(FCPATH . ltrim($post['thumbnail'], '/'))) {
                unlink(FCPATH . ltrim($post['thumbnail'], '/'));
            }

            list($type, $data) = explode(';', $pastedThumbnail);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $thumbnailName = uniqid() . '.png';
            file_put_contents(FCPATH . 'uploads/thumbnails/' . $thumbnailName, $data);
            $postData['thumbnail'] = base_url('uploads/thumbnails/' . $thumbnailName);
        } else {
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
            $tags = $this->request->getPost('tags');
            $tagIds = [];
            if (!empty($tags)) {
                $tagModel = new TagModel();
                $tagNames = explode(',', $tags);
                foreach ($tagNames as $tagName) {
                    $tagName = trim($tagName);
                    if (empty($tagName)) continue;

                    $slug = url_title($tagName, '-', true);
                    $tag = $tagModel->where('slug', $slug)->first();
                    if (!$tag) {
                        $tagId = $tagModel->insert([
                            'name' => $tagName,
                            'slug' => $slug,
                        ]);
                        $tagIds[] = $tagId;
                    } else {
                        $tagIds[] = $tag['id'];
                    }
                }
            }
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

    public function upload_image()
    {
        $validationRules = [
            'file' => 'uploaded[file]|max_size[file,2048]|is_image[file]|mime_in[file,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (! $this->validate($validationRules)) {
            return $this->response->setStatusCode(400, json_encode(['error' => $this->validator->getErrors()]));
        }

        $file = $this->request->getFile('file');

        if ($file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/posts', $newName);

            $url = base_url('uploads/posts/' . $newName);

            return $this->response->setJSON(['location' => $url]);
        }

        return $this->response->setStatusCode(500, 'Image upload failed.');
    }
}
