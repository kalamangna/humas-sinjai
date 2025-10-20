<?php

namespace App\Controllers\Admin;

use App\Models\CarouselSlideModel;

class Carousel extends BaseController
{
    protected $carouselSlideModel;

    public function __construct()
    {
        $this->carouselSlideModel = new CarouselSlideModel();
    }

    public function index()
    {
        $data = [
            'slides' => $this->carouselSlideModel->orderBy('slide_order', 'ASC')->findAll(),
        ];

        return $this->render('Admin/Carousel/index', $data);
    }

    public function new()
    {
        return $this->render('Admin/Carousel/new');
    }

    public function create()
    {
        $validationRules = [
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'slide_order' => 'is_natural_no_zero',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');

        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/carousel', $newName);

            $this->carouselSlideModel->save([
                'image_path' => base_url('uploads/carousel/' . $newName),
                'slide_order' => $this->request->getPost('slide_order'),
            ]);

            return redirect()->to(base_url('/admin/carousel'))->with('success', 'Slide berhasil dibuat.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
    }

    public function edit($id)
    {
        $data = [
            'slide' => $this->carouselSlideModel->find($id),
        ];

        return $this->render('Admin/Carousel/edit', $data);
    }

    public function update($id)
    {
        $validationRules = [
            'image' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'slide_order' => 'is_natural_no_zero',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slide = $this->carouselSlideModel->find($id);
        $image = $this->request->getFile('image');

        $data = [
            'slide_order' => $this->request->getPost('slide_order'),
        ];

        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/carousel', $newName);
            $data['image_path'] = base_url('uploads/carousel/' . $newName);

            // Delete old image
            if ($slide && !empty($slide['image_path']) && file_exists(FCPATH . $slide['image_path'])) {
                unlink(FCPATH . $slide['image_path']);
            }
        }

        $this->carouselSlideModel->update($id, $data);

        return redirect()->to(base_url('/admin/carousel'))->with('success', 'Slide berhasil diperbarui.');
    }

    public function delete($id)
    {
        $slide = $this->carouselSlideModel->find($id);

        if ($slide && !empty($slide['image_path']) && file_exists(FCPATH . $slide['image_path'])) {
            unlink(FCPATH . $slide['image_path']);
        }

        $this->carouselSlideModel->delete($id);

        return redirect()->to(base_url('/admin/carousel'))->with('success', 'Slide berhasil dihapus.');
    }
}
