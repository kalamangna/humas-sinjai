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
        return view('widget_guide', $data);
    }
}