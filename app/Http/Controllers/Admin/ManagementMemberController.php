<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreManagementMemberRequest;
use App\Http\Requests\Admin\UpdateManagementMemberRequest;
use App\Models\ManagementMember;
use Illuminate\Support\Facades\Storage;

class ManagementMemberController extends Controller
{
    public function index()
    {
        $managementMembers = ManagementMember::orderBy('sort_order')->paginate(10);

        return view('admin.management.index', compact('managementMembers'));
    }

    public function create()
    {
        return view('admin.management.create', [
            'member' => new ManagementMember(),
        ]);
    }

    public function store(StoreManagementMemberRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['photo'] = $request->file('photo')->store('management', 'public');

        ManagementMember::create($data);

        return redirect()
            ->route('admin.management.index')
            ->with('status', 'Anggota tim manajemen berhasil ditambahkan.');
    }

    public function edit(ManagementMember $management)
    {
        return view('admin.management.edit', ['member' => $management]);
    }

    public function update(UpdateManagementMemberRequest $request, ManagementMember $management)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($management->photo) {
                Storage::disk('public')->delete($management->photo);
            }
            $data['photo'] = $request->file('photo')->store('management', 'public');
        }

        $management->update($data);

        return redirect()
            ->route('admin.management.index')
            ->with('status', 'Anggota tim manajemen berhasil diperbarui.');
    }

    public function destroy(ManagementMember $management)
    {
        if ($management->photo) {
            Storage::disk('public')->delete($management->photo);
        }

        $management->delete();

        return redirect()
            ->route('admin.management.index')
            ->with('status', 'Anggota tim manajemen berhasil dihapus.');
    }
}