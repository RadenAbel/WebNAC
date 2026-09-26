<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJoinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'nickname'   => ['nullable', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before:today', 'after:1900-01-01'],
            // Format nomor HP Indonesia: 08xxxxxxxxxx / +62xxxxxxxxxx / 62xxxxxxxxxx,
            // total 9-13 digit setelah kode awal — nolak asal-asalan kayak "123" atau teks acak.
            'whatsapp'   => ['required', 'string', 'max:20', 'regex:/^(\+?62|0)8[0-9]{8,12}$/'],
            'category'   => ['required', 'string', 'max:100'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'], // maks 8MB (otomatis dikompres)

            // Honeypot anti-bot: field ini SENGAJA disembunyikan lewat CSS di
            // form (bukan type="hidden", karena bot spam biasanya sudah pintar
            // mengabaikan hidden field, tapi jarang yang cek visibility CSS).
            // Manusia normal tidak akan pernah mengisinya karena tidak
            // kelihatan; kalau terisi, hampir pasti itu bot -> ditolak diam-diam
            // (pesan generik, tidak bocorkan bahwa ini pengecekan anti-bot).
            'website'    => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before'   => 'Tanggal lahir tidak valid.',
            'birth_date.after'    => 'Tanggal lahir tidak valid.',
            'whatsapp.required'   => 'Nomor WhatsApp wajib diisi supaya kami bisa menghubungi Anda.',
            'whatsapp.regex'      => 'Format nomor WhatsApp tidak valid. Gunakan format seperti 08123456789.',
            'category.required'   => 'Silakan pilih kategori kelas yang diminati.',
            'photo.image'         => 'File harus berupa gambar.',
            'photo.mimes'         => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'           => 'Ukuran foto maksimal 8MB.',
            'website.prohibited'  => 'Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.',
        ];
    }
}