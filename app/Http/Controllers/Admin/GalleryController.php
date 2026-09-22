<?php

namespace App\Http\Controllers\Admin;

use App\Support\ImageOptimizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->paginate(12);

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create', [
            'gallery' => new Gallery(),
        ]);
    }

    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($data['type'] === 'photo' && $request->hasFile('image')) {
            $data['image'] = ImageOptimizer::store($request->file('image'), 'galleries');
        } else {
            $data['image'] = null; // type video tidak butuh upload gambar (pakai thumbnail YouTube)
        }

        Gallery::create($data);

        return redirect()
            ->route('admin.galleries.index')
            ->with('status', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($data['type'] === 'video') {
            // Pindah ke video: foto lama (kalau ada) sudah tidak dipakai, hapus dari storage.
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = ImageOptimizer::store($request->file('image'), 'galleries');
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.galleries.index')
            ->with('status', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.galleries.index')
            ->with('status', 'Foto galeri berhasil dihapus.');
    }
}