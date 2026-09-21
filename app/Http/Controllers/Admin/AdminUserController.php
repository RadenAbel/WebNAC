<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User();

        return view('admin.users.create', compact('user'));
    }

    public function store(StoreAdminUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();

        // Super Admin selalu akses semua (permissions di-set null, diabaikan
        // total oleh User::canAccess()) — checkbox di form sengaja
        // disembunyikan untuk role ini juga, ini cuma jaga-jaga di backend.
        $data['permissions'] = $data['role'] === 'super_admin' ? null : ($data['permissions'] ?? []);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Akun {$data['name']} berhasil dibuat.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateAdminUserRequest $request, User $user)
    {
        $data = $request->validated();

        $data['permissions'] = $data['role'] === 'super_admin' ? null : ($data['permissions'] ?? []);

        // Password kosong = tidak diubah (biar admin tidak wajib isi ulang
        // password tiap kali cuma mau ubah nama/role-nya saja).
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Akun {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        // Jaga-jaga supaya Super Admin tidak bisa menghapus akunnya sendiri
        // (bisa bikin situs kehilangan akses Super Admin sama sekali).
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('status_error', 'Tidak bisa menghapus akun yang sedang Anda pakai sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Akun {$name} berhasil dihapus.");
    }
}