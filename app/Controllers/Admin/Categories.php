<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index()
    {
        $postModel = new \App\Models\PostModel(); // Need this for total posts

        // Get filters from request
        $filters = [
            'search'   => $this->request->getGet('search'),
        ];

        $builder = $this->model
            ->select('categories.*, parent.name as parent_name, COUNT(post_categories.post_id) as post_count')
            ->join('post_categories', 'post_categories.category_id = categories.id', 'left')
            ->join('categories as parent', 'parent.id = categories.parent_id', 'left')
            ->groupBy('categories.id');

        if (!empty($filters['search'])) {
            $builder->like('categories.name', $filters['search']);
        }

        $data = [
            'categories'        => $builder->orderBy('categories.name', 'ASC')->paginate(10),
            'pager'             => $this->model->pager,
            'filters'           => $filters,
            'total_categories'  => $this->data['total_categories'], // Use data from BaseController
            'active_categories' => $this->model->join('post_categories', 'post_categories.category_id = categories.id')->countAll(),
            'total_posts'       => $this->data['total_posts'],
        ];

        return $this->render('Admin/Categories/index', $data);
    }

    public function new()
    {
        $data['categories'] = $this->model->orderBy('name', 'ASC')->findAll();
        return $this->render('Admin/Categories/new', $data);
    }

    public function create()
    {
        $parentId = $this->request->getPost('parent_id');

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'parent_id' => empty($parentId) ? null : $parentId,
        ];

if ($this->model->save($data)) {
            return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil dibuat.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $data['category'] = $this->model->find($id);
        $data['categories'] = $this->model->orderBy('name', 'ASC')->findAll();

        if (empty($data['category'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the category: ' . $id);
        }

        return $this->render('Admin/Categories/edit', $data);
    }

    public function update($id = null)
    { 
        $parentId = $this->request->getPost('parent_id');
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'parent_id' => empty($parentId) ? null : $parentId,
        ];

if ($this->model->update($id, $data)) {
            return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
if ($this->model->delete($id)) {
            return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/categories'))->with('error', 'Error deleting category.');
    }
}