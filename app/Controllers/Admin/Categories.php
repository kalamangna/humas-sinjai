<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;

class Categories extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $postModel = new \App\Models\PostModel(); // Need this for total posts

        // Get filters from request
        $filters = [
            'search'   => $this->request->getGet('search'),
        ];

        $builder = $categoryModel
            ->select('categories.*, COUNT(post_categories.post_id) as post_count')
            ->join('post_categories', 'post_categories.category_id = categories.id', 'left')
            ->groupBy('categories.id');

        if (!empty($filters['search'])) {
            $builder->like('categories.name', $filters['search']);
        }

        $data = [
            'categories'        => $builder->orderBy('categories.name', 'ASC')->paginate(10),
            'pager'             => $categoryModel->pager,
            'filters'           => $filters,
            'total_categories'  => $this->data['total_categories'], // Use data from BaseController
            'active_categories' => $categoryModel->join('post_categories', 'post_categories.category_id = categories.id')->countAll(),
            'total_posts'       => $this->data['total_posts'],
        ];

        return $this->render('Admin/Categories/index', $data);
    }

    public function new()
    {
        return $this->render('Admin/Categories/new');
    }

    public function create()
    {
        $categoryModel = new CategoryModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
        ];

        if ($categoryModel->save($data)) {
            return redirect()->to(base_url('admin/categories'))->with('message', 'Category created successfully.');
        }

        return redirect()->back()->withInput()->with('errors', $categoryModel->errors());
    }

    public function edit($id = null)
    {
        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->find($id);

        if (empty($data['category'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the category: ' . $id);
        }

        return $this->render('Admin/Categories/edit', $data);
    }

    public function update($id = null)
    { 
        $categoryModel = new CategoryModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
        ];

        if ($categoryModel->update($id, $data)) {
            return redirect()->to(base_url('admin/categories'))->with('message', 'Category updated successfully.');
        }

        return redirect()->back()->withInput()->with('errors', $categoryModel->errors());
    }

    public function delete($id = null)
    {
        $categoryModel = new CategoryModel();
        if ($categoryModel->delete($id)) {
            return redirect()->to(base_url('admin/categories'))->with('message', 'Category deleted successfully.');
        }

        return redirect()->to(base_url('admin/categories'))->with('error', 'Error deleting category.');
    }
}