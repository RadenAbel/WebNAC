<?php

namespace App\Support;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use Throwable;

class TwoFactor
{
    private const WINDOW = 1;

    public static function generateSecret(): string
    {
        return (new Google2FA())->generateSecretKey(32);
    }

    public static function qrCodeSvg(User $user, string $secret): string
    {
        $url = (new Google2FA())->getQRCodeUrl(
            config('seo.club_name', 'Nugroho Aquatic Club') . ' Admin',
            $user->email,
            $secret
        );

        $writer = new Writer(new ImageRenderer(new RendererStyle(200, 1), new SvgImageBackEnd()));

        return $writer->writeString($url);
    }

    public static function verifySecret(string $secret, string $code): bool
    {
        try {
            return (bool) (new Google2FA())->verifyKey($secret, static::digits($code), self::WINDOW);
        } catch (Throwable) {
            return false;
        }
    }

    public static function verify(User $user, string $code): bool
    {
        if (! $user->two_factor_secret) {
            return false;
        }

        try {
            $timestamp = (new Google2FA())->verifyKeyNewer(
                $user->two_factor_secret,
                static::digits($code),
                $user->two_factor_last_used,
                self::WINDOW
            );
        } catch (Throwable) {
            return false;
        }

        if ($timestamp === false) {
            return false;
        }

        $user->forceFill(['two_factor_last_used' => $timestamp])->save();

        return true;
    }

    public static function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))
            ->map(fn () => Str::upper(Str::random(5) . '-' . Str::random(5)))
            ->all();
    }

    public static function useRecoveryCode(User $user, string $code): bool
    {
        $code = Str::upper(trim($code));
        $codes = $user->two_factor_recovery_codes ?? [];

        foreach ($codes as $i => $stored) {
            if (hash_equals($stored, $code)) {
                unset($codes[$i]);
                $user->forceFill(['two_factor_recovery_codes' => array_values($codes)])->save();

                return true;
            }
        }

        return false;
    }

    private static function digits(string $code): string
    {
        return preg_replace('/\D/', '', $code);
    }
}
