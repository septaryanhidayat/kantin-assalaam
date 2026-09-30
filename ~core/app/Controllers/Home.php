<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title'    => 'Home',
            'header'   => $this->landing_header->find(1),
            'featured' => $this->landing_featured->find(1),
            'kepala'   => $this->landing_kepala_sekolah->find(1),
            'gallery'  => $this->landing_gallery->find(1),
        ];

        return view('index', $data);
    }
}
