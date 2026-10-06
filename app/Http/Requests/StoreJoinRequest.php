<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'whatsapp'   => ['required', 'string', 'max:20', 'regex:/^(\+?62|0)8[0-9]{8,12}$/'],
            'category'   => ['required', 'string', Rule::in(['Novato', 'Avance', 'Campeón'])],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],

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
            'category.in'         => 'Kategori kelas yang dipilih tidak valid.',
            'photo.dimensions'    => 'Resolusi foto terlalu besar (maksimal 6000 × 6000 piksel).',
            'photo.image'         => 'File harus berupa gambar.',
            'photo.mimes'         => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'           => 'Ukuran foto maksimal 8MB.',
            'website.prohibited'  => 'Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.',
        ];
    }
}
