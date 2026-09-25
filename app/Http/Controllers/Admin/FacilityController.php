<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFacilityRequest;
use App\Http\Requests\Admin\UpdateFacilityRequest;
use App\Models\Facility;
use App\Support\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::ordered()->get();

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create', ['facility' => new Facility()]);
    }

    public function store(StoreFacilityRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('photo')) {
            $data['photo'] = ImageOptimizer::store($request->file('photo'), 'facilities');
        }

        Facility::create($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(UpdateFacilityRequest $request, Facility $facility)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('photo')) {
            if ($facility->photo) {
                Storage::disk('public')->delete($facility->photo);
            }
            $data['photo'] = ImageOptimizer::store($request->file('photo'), 'facilities');
        }

        $facility->update($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->photo) {
            Storage::disk('public')->delete($facility->photo);
        }

        $facility->delete();

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Fasilitas berhasil dihapus.');
    }
}