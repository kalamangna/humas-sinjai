<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        // Get filters from request
        $filters = [
            'search'   => $this->request->getGet('search'),
        ];

        $builder = $userModel
            ->select('users.*, COUNT(posts.id) as post_count')
            ->join('posts', 'posts.user_id = users.id', 'left')
            ->groupBy('users.id');

        if (!empty($filters['search'])) {
            $builder->like('users.name', $filters['search']);
        }

        $data = [
            'users'          => $builder->orderBy('users.name', 'ASC')->paginate(10),
            'pager'          => $userModel->pager,
            'filters'        => $filters,
            'total_users'    => $userModel->countAllResults(),
            'admin_users'    => $userModel->where('role', 'admin')->countAllResults(),
            'author_users'   => $userModel->where('role', 'author')->countAllResults(),
            'current_user_id' => session()->get('user_id'),
        ];

        return $this->render('Admin/Users/index', $data);
    }

    public function new()
    {
        return $this->render('Admin/Users/new');
    }

    public function create()
    {
        $userModel = new UserModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
        ];

        if ($userModel->save($data)) {
            return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil dibuat.');
        }

        return redirect()->back()->withInput()->with('errors', $userModel->errors());
    }

    public function show($id = null)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user: ' . $id);
        }

        return $this->render('Admin/Users/show', $data);
    }

    public function edit($id = null)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user: ' . $id);
        }

        return $this->render('Admin/Users/edit', $data);
    }

    public function update($id = null)
    {
        $userModel = new UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($userModel->update($id, $data)) {
            return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('errors', $userModel->errors());
    }

    public function delete($id = null)
    {
        $userModel = new UserModel();
        if ($userModel->delete($id)) {
            return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/users'))->with('error', 'Error deleting user.');
    }

    public function profile()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $data['user'] = $userModel->find($userId);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user profile.');
        }

        return $this->render('Admin/Users/profile', $data);
    }

    public function settings()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $data['user'] = $userModel->find($userId);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find user settings.');
        }

        return $this->render('Admin/Users/settings', $data);
    }

    public function update_settings()
    {
        $userModel = new UserModel();
        $userId = $this->request->getPost('user_id');
        $user = $userModel->find($userId);

        if (empty($user)) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $validationRules = [
            'name'  => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
        ];

        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        if (!empty($password)) {
            $validationRules['password'] = 'min_length[8]';
            $validationRules['password_confirm'] = 'matches[password]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email')
        ];

        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($userModel->update($userId, $userData)) {
            // Update session data if current user's profile is updated
            if (session()->get('user_id') == $userId) {
                session()->set('name', $userData['name']);
                session()->set('email', $userData['email']);
            }
            return redirect()->to(base_url('admin'))->with('message', 'Pengaturan profil berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengaturan profil.');
    }
}