<?php

namespace App\Controllers\Admin;

use App\Models\ProfileModel;

class Profiles extends BaseController
{
    public function index()
    {
        $profileModel = new ProfileModel();

        $data = [
            'profiles' => $profileModel->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->findAll(),
        ];

        return $this->render('Admin/Profiles/index', $data);
    }

    public function new()
    {
        return $this->render('Admin/Profiles/new');
    }

    public function create()
    {
        $validationRules = [
            'name'     => 'required|min_length[3]|max_length[255]',
            'type'     => 'required|in_list[bupati,wakil-bupati,sekda,forkopimda,eselon-ii,eselon-iii,eselon-iv,kepala-desa]',
        ];

        $selectedType = $this->request->getPost('type');
        $isTableType = in_array($selectedType, ['forkopimda', 'eselon-ii', 'eselon-iii', 'eselon-iv', 'kepala-desa']);

        if (!$isTableType && empty($this->request->getPost('pasted_image')) && $this->request->getFile('image')->getName() !== '') {
            $validationRules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $profileModel = new ProfileModel();

        // Handle file upload
        $imageName = null;
        $pastedImage = $this->request->getPost('pasted_image');

        if (!empty($pastedImage)) {
            list($type, $data) = explode(';', $pastedImage);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $tempPath = WRITEPATH . 'uploads/' . uniqid() . '.webp';
            file_put_contents($tempPath, $data);
            $processedImagePath = processImage($tempPath); // Assuming processImage helper exists as used in Posts
            $imageName = uniqid() . '.webp';
            rename($processedImagePath, FCPATH . 'uploads/profiles/' . $imageName);
            $imageName = base_url('uploads/profiles/' . $imageName);
        } else {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                // Ensure directory exists
                if (!is_dir(FCPATH . 'uploads/profiles')) {
                    mkdir(FCPATH . 'uploads/profiles', 0755, true);
                }
                
                $processedImagePath = processImage($file->getRealPath());
                $imageName = uniqid() . '.webp';
                rename($processedImagePath, FCPATH . 'uploads/profiles/' . $imageName);
                $imageName = base_url('uploads/profiles/' . $imageName);
            }
        }

        $slug = url_title($this->request->getPost('name'), '-', true);
        // Ensure unique slug
        if ($profileModel->where('slug', $slug)->first()) {
            $slug = $slug . '-' . uniqid();
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $slug,
            'position'    => $this->request->getPost('position'),
            'institution' => $this->request->getPost('institution'),
            'type'        => $this->request->getPost('type'),
            'bio'         => $this->request->getPost('bio'),
            'image'       => $imageName,
            'order'       => $this->request->getPost('order') ? (int)$this->request->getPost('order') : 0,
        ];

        if ($profileModel->save($data)) {
            return redirect()->to(base_url('admin/profiles'))->with('success', 'Profil berhasil dibuat.');
        }

        return redirect()->back()->withInput()->with('errors', $profileModel->errors());
    }

    public function edit($id = null)
    {
        $profileModel = new ProfileModel();
        $data['profile'] = $profileModel->find($id);

        if (empty($data['profile'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the profile: ' . $id);
        }

        return $this->render('Admin/Profiles/edit', $data);
    }

    public function update($id = null)
    {
        $profileModel = new ProfileModel();
        $profile = $profileModel->find($id);

        if (empty($profile)) {
            return redirect()->back()->with('error', 'Profile not found.');
        }

        $validationRules = [
            'name'     => 'required|min_length[3]|max_length[255]',
            'type'     => 'required|in_list[bupati,wakil-bupati,sekda,forkopimda,eselon-ii,eselon-iii,eselon-iv,kepala-desa]',
        ];

        $selectedType = $this->request->getPost('type');
        $isTableType = in_array($selectedType, ['forkopimda', 'eselon-ii', 'eselon-iii', 'eselon-iv', 'kepala-desa']);

        if (!$isTableType && empty($this->request->getPost('pasted_image')) && $this->request->getFile('image')->getName() !== '') {
            $validationRules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'position'    => $this->request->getPost('position'),
            'institution' => $this->request->getPost('institution'),
            'type'        => $this->request->getPost('type'),
            'bio'         => $this->request->getPost('bio'),
            'order'       => $this->request->getPost('order') ? (int)$this->request->getPost('order') : 0,
        ];

        // Handle file upload
        $pastedImage = $this->request->getPost('pasted_image');
        if (!empty($pastedImage)) {
             // Delete old image if it exists
             if (! empty($profile['image']) && file_exists(FCPATH . ltrim(parse_url($profile['image'], PHP_URL_PATH), '/'))) {
                unlink(FCPATH . ltrim(parse_url($profile['image'], PHP_URL_PATH), '/'));
            }

            list($type, $imgData) = explode(';', $pastedImage);
            list(, $imgData)      = explode(',', $imgData);
            $imgData = base64_decode($imgData);
            $tempPath = WRITEPATH . 'uploads/' . uniqid() . '.webp';
            file_put_contents($tempPath, $imgData);
            $processedImagePath = processImage($tempPath);
            $imageName = uniqid() . '.webp';
            rename($processedImagePath, FCPATH . 'uploads/profiles/' . $imageName);
            $data['image'] = base_url('uploads/profiles/' . $imageName);
        } else {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                // Delete old image if it exists
                if (! empty($profile['image']) && file_exists(FCPATH . ltrim(parse_url($profile['image'], PHP_URL_PATH), '/'))) {
                    unlink(FCPATH . ltrim(parse_url($profile['image'], PHP_URL_PATH), '/'));
                }

                // Ensure directory exists
                if (!is_dir(FCPATH . 'uploads/profiles')) {
                    mkdir(FCPATH . 'uploads/profiles', 0755, true);
                }

                $processedImagePath = processImage($file->getRealPath());
                $imageName = uniqid() . '.webp';
                rename($processedImagePath, FCPATH . 'uploads/profiles/' . $imageName);
                $data['image'] = base_url('uploads/profiles/' . $imageName);
            }
        }

        if ($profileModel->update($id, $data)) {
            return redirect()->to(base_url('admin/profiles'))->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('errors', $profileModel->errors());
    }

    public function delete($id = null)
    {
        $profileModel = new ProfileModel();
        if ($profileModel->delete($id)) {
            return redirect()->to(base_url('admin/profiles'))->with('success', 'Profil berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/profiles'))->with('error', 'Error deleting profile.');
    }
}
