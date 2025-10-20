<?php

namespace App\Controllers\Admin;

use App\Models\TagModel;

class Tags extends BaseController
{
    public function index()
    {
        $tagModel = new TagModel();
        $postModel = new \App\Models\PostModel(); // Need this for total posts

        // Get filters from request
        $filters = [
            'search'   => $this->request->getGet('search'),
        ];

        $builder = $tagModel
            ->select('tags.*, COUNT(post_tags.post_id) as post_count')
            ->join('post_tags', 'post_tags.tag_id = tags.id', 'left')
            ->groupBy('tags.id');

        if (!empty($filters['search'])) {
            $builder->like('tags.name', $filters['search']);
        }

        $data = [
            'tags'              => $builder->orderBy('tags.name', 'ASC')->paginate(10),
            'pager'             => $tagModel->pager,
            'filters'           => $filters,
            'total_tags'        => $this->data['total_tags'], // Use data from BaseController
            'active_tags'       => $tagModel->join('post_tags', 'post_tags.tag_id = tags.id')->countAll(),
            'total_posts'       => $this->data['total_posts'],
        ];

        return $this->render('Admin/Tags/index', $data);
    }

    public function new()
    {
        return $this->render('Admin/Tags/new');
    }

    public function create()
    {
        $tagModel = new TagModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
        ];

        if ($tagModel->save($data)) {
            return redirect()->to(base_url('admin/tags'))->with('success', 'Tag berhasil dibuat.');
        }

        return redirect()->back()->withInput()->with('errors', $tagModel->errors());
    }

    public function edit($id = null)
    {
        $tagModel = new TagModel();
        $data['tag'] = $tagModel->find($id);

        if (empty($data['tag'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the tag: ' . $id);
        }

        return $this->render('Admin/Tags/edit', $data);
    }

    public function update($id = null)
    {
        $tagModel = new TagModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
        ];

        if ($tagModel->update($id, $data)) {
            return redirect()->to(base_url('admin/tags'))->with('success', 'Tag berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('errors', $tagModel->errors());
    }

    public function delete($id = null)
    {
        $tagModel = new TagModel();
        if ($tagModel->delete($id)) {
            return redirect()->to(base_url('admin/tags'))->with('success', 'Tag berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/tags'))->with('error', 'Error deleting tag.');
    }
}