<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\SiteSetting;

class GalleryController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::current();
        $galleries = Gallery::active()->paginate(15);

        return view('gallery.index', compact('setting', 'galleries'));
    }
}