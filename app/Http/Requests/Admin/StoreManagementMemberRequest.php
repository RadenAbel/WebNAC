<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagementMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:150'],
            'position'   => ['required', 'string', 'max:150'],
            // Wajib saat tambah baru; di UpdateManagementMemberRequest
            // di-override jadi 'nullable' (foto lama boleh dipertahankan).
            'photo'      => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'short_bio'  => ['nullable', 'string', 'max:500'],
            'full_bio'   => ['nullable', 'string', 'max:20000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'photo.required'    => 'Foto wajib diupload.',
            'photo.image'       => 'File harus berupa gambar.',
            'photo.mimes'       => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'         => 'Ukuran foto maksimal 3MB.',
        ];
    }
}