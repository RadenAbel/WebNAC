<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AccountPasswordController extends Controller
{
    /**
     * Form ganti password — untuk akun yang SEDANG LOGIN (admin maupun
     * super admin). Mengganti password akun orang lain tetap lewat menu
     * Kelola Admin (khusus super admin).
     */
    public function edit()
    {
        return view('admin.account.password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Wajib isi password lama yang benar — supaya orang yang kebetulan
            // memakai laptop admin yang lupa logout tidak bisa mengambil alih akun.
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
                Password::min(8)->letters()->numbers(),
            ],
        ], [
            'current_password.required'         => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.required'                 => 'Password baru wajib diisi.',
            'password.confirmed'                => 'Konfirmasi password baru tidak cocok.',
            'password.different'                => 'Password baru harus berbeda dari password lama.',
            'password.min'                      => 'Password baru minimal 8 karakter.',
            'password.letters'                  => 'Password baru harus mengandung huruf.',
            'password.numbers'                  => 'Password baru harus mengandung angka.',
        ]);

        $user = $request->user();

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            // Ganti token "Ingat saya" — perangkat lain yang login lewat
            // cookie "Ingat saya" otomatis harus login ulang.
            'remember_token' => Str::random(60),
        ])->save();

        // Perangkat lain yang sedang login otomatis ter-logout berkat
        // middleware 'auth.session' di grup route admin (lihat routes/web.php).
        // Sesi di perangkat ini dibuat ulang supaya tetap login dengan aman.
        $request->session()->regenerate();

        return redirect()
            ->route('admin.password.edit')
            ->with('status', 'Password berhasil diganti. Perangkat lain yang memakai akun ini otomatis ter-logout.');
    }
}