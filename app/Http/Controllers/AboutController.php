<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;

class AboutController extends Controller
{
    /**
     * Halaman "Tentang Kami".
     *
     * ⚠️ Cara ambil $setting di bawah ini cuma tebakan mengikuti pola yang
     * dipakai di blade (about_photo_url, since_year, about_title,
     * about_description — field yang sama dengan yang dipakai di beranda).
     * Samakan baris ini dengan cara HomeController::index() mengambil
     * $setting, supaya datanya konsisten di kedua halaman.
     */
    public function index()
    {
        $setting = SiteSetting::first();

        return view('about.index', compact('setting'));
    }
}