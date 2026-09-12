<?php

namespace App\Http\Controllers;

class RegionController extends Controller
{
    public function index()
    {
        // Data bentuk kecamatan (SVG path) + titik wisata sudah "matang" di
        // file JSON ini — dihasilkan dari data batas administrasi resmi
        // (GADM) yang sudah diproyeksikan ke koordinat SVG, plus titik
        // wisata yang sudah diverifikasi dari sumber berita/resmi.
        //
        // ⚠️ Taruh file kutim-map.json di: resources/data/kutim-map.json
        $path = resource_path('data/kutim-map.json');

        $mapData = file_exists($path)
            ? json_decode(file_get_contents($path), true)
            : ['viewBox' => '0 0 1000 613', 'kecamatan' => [], 'attractions' => []];

        return view('region.index', compact('mapData'));
    }
}