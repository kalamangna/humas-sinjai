<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        $data['title'] = 'Tentang';
        return view('about', $data);
    }

    public function contact()
    {
        $data['title'] = 'Kontak';
        return view('contact', $data);
    }

    public function widget()
    {
        $data['title'] = 'Panduan Widget';
        $data['description'] = 'Panduan lengkap untuk memasang widget berita Humas Sinjai di situs web Anda. Tampilkan berita terbaru dengan mudah.';
        $data['image'] = base_url('meta.png');
        return view('widget_guide', $data);
    }
}