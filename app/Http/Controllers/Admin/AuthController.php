<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Support\TwoFactor;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private const TWO_FACTOR_KEY = 'login.two_factor';

    /**
     * Tampilkan form login admin.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // Cek email & password TANPA langsung login — akun yang memakai
        // verifikasi dua langkah masih harus memasukkan kode dari aplikasinya.
        if (! Auth::validate($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $user = Auth::getLastAttempted();

        if ($user->hasTwoFactorEnabled()) {
            $request->session()->put(self::TWO_FACTOR_KEY, [
                'id'       => $user->id,
                'remember' => $remember,
                'expires'  => now()->addMinutes(5)->timestamp,
            ]);

            return redirect()->route('admin.two-factor.challenge');
        }

        return $this->completeLogin($request, $user, $remember);
    }

    /**
     * Langkah kedua login: form kode 6 digit (atau kode pemulihan).
     */
    public function showTwoFactorChallenge(Request $request)
    {
        if (! $this->pendingTwoFactorUser($request)) {
            return redirect()->route('login');
        }

        return view('admin.auth.two-factor-challenge');
    }

    public function verifyTwoFactorChallenge(Request $request)
    {
        $user = $this->pendingTwoFactorUser($request);

        if (! $user) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Waktu verifikasi habis. Silakan login ulang.']);
        }

        $request->validate([
            'code'          => ['nullable', 'string', 'max:20'],
            'recovery_code' => ['nullable', 'string', 'max:20'],
        ]);

        $valid = $request->filled('recovery_code')
            ? TwoFactor::useRecoveryCode($user, $request->input('recovery_code'))
            : ($request->filled('code') && TwoFactor::verify($user, $request->input('code')));

        if (! $valid) {
            return back()->withErrors([
                'code' => $request->filled('recovery_code')
                    ? 'Kode pemulihan tidak sesuai atau sudah pernah dipakai.'
                    : 'Kode tidak sesuai. Gunakan kode terbaru dari aplikasi authenticator.',
            ]);
        }

        $remember = (bool) ($request->session()->get(self::TWO_FACTOR_KEY)['remember'] ?? false);
        $request->session()->forget(self::TWO_FACTOR_KEY);

        return $this->completeLogin($request, $user, $remember);
    }

    private function completeLogin(Request $request, User $user, bool $remember)
    {
        Auth::login($user, $remember);

        // Regenerate session ID setelah login berhasil — mencegah
        // session fixation attack (praktik keamanan standar Laravel).
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /** Akun yang sudah lolos email & password, sedang menunggu kode 2FA (maks 5 menit). */
    private function pendingTwoFactorUser(Request $request): ?User
    {
        $pending = $request->session()->get(self::TWO_FACTOR_KEY);

        if (! $pending || ($pending['expires'] ?? 0) < now()->timestamp) {
            $request->session()->forget(self::TWO_FACTOR_KEY);

            return null;
        }

        $user = User::find($pending['id']);

        return $user && $user->hasTwoFactorEnabled() ? $user : null;
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}