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
            'birth_date' => ['required', 'date', 'before:today'],
            'whatsapp'   => ['required', 'string', 'max:20'],
            'category'   => ['required', 'string', 'max:100'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // maks 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before'   => 'Tanggal lahir tidak valid.',
            'whatsapp.required'   => 'Nomor WhatsApp wajib diisi supaya kami bisa menghubungi Anda.',
            'category.required'   => 'Silakan pilih kategori kelas yang diminati.',
            'photo.image'         => 'File harus berupa gambar.',
            'photo.mimes'         => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'           => 'Ukuran foto maksimal 2MB.',
        ];
    }
}