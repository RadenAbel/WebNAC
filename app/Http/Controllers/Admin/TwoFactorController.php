<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\TwoFactor;
use Illuminate\Http\Request;

/**
 * Pengaturan verifikasi dua langkah untuk akun yang sedang login.
 */
class TwoFactorController extends Controller
{
    private const PENDING_KEY = 'two_factor.pending_secret';

    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->hasTwoFactorEnabled()) {
            return view('admin.account.two-factor', [
                'enabled'        => true,
                'remainingCodes' => count($user->two_factor_recovery_codes ?? []),
            ]);
        }

        // Rahasia baru disimpan di sesi dulu — baru masuk database setelah
        // admin berhasil memasukkan kode pertama dari aplikasinya.
        $secret = $request->session()->get(self::PENDING_KEY);
        if (! $secret) {
            $secret = TwoFactor::generateSecret();
            $request->session()->put(self::PENDING_KEY, $secret);
        }

        return view('admin.account.two-factor', [
            'enabled' => false,
            'secret'  => $secret,
            'qrSvg'   => TwoFactor::qrCodeSvg($user, $secret),
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate(
            ['code' => ['required', 'string']],
            ['code.required' => 'Masukkan kode 6 digit dari aplikasi authenticator.']
        );

        $secret = $request->session()->get(self::PENDING_KEY);

        if (! $secret || ! TwoFactor::verifySecret($secret, $request->input('code'))) {
            return back()->withErrors(['code' => 'Kode tidak sesuai. Pastikan jam di HP sudah otomatis, lalu coba kode terbaru.']);
        }

        $codes = TwoFactor::generateRecoveryCodes();

        $request->user()->forceFill([
            'two_factor_secret'         => $secret,
            'two_factor_recovery_codes' => $codes,
            'two_factor_confirmed_at'   => now(),
            'two_factor_last_used'      => null,
        ])->save();

        $request->session()->forget(self::PENDING_KEY);

        return redirect()
            ->route('admin.two-factor.show')
            ->with('status', 'Verifikasi dua langkah berhasil diaktifkan.')
            ->with('recovery_codes', $codes);
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate(
            ['current_password' => ['required', 'current_password']],
            ['current_password.required' => 'Password wajib diisi.', 'current_password.current_password' => 'Password tidak sesuai.']
        );

        $codes = TwoFactor::generateRecoveryCodes();
        $request->user()->forceFill(['two_factor_recovery_codes' => $codes])->save();

        return redirect()
            ->route('admin.two-factor.show')
            ->with('status', 'Kode pemulihan baru berhasil dibuat. Kode lama sudah tidak berlaku.')
            ->with('recovery_codes', $codes);
    }

    public function disable(Request $request)
    {
        $request->validate(
            ['current_password' => ['required', 'current_password']],
            ['current_password.required' => 'Password wajib diisi.', 'current_password.current_password' => 'Password tidak sesuai.']
        );

        $request->user()->forceFill([
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at'   => null,
            'two_factor_last_used'      => null,
        ])->save();

        return redirect()
            ->route('admin.two-factor.show')
            ->with('status', 'Verifikasi dua langkah dinonaktifkan.');
    }
}