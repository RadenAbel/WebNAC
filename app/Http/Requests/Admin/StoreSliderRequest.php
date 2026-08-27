<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Wajib saat tambah baru, tapi di UpdateSliderRequest kita
            // override jadi 'nullable' (lihat class itu) karena saat edit,
            // foto lama boleh dipertahankan tanpa upload ulang.
            'image'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'title'       => ['nullable', 'string', 'max:150'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:50'],
            'button_url'  => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Foto slider wajib diupload.',
            'image.image'    => 'File harus berupa gambar.',
            'image.mimes'    => 'Format foto harus JPG, PNG, atau WEBP.',
            'image.max'      => 'Ukuran foto maksimal 3MB.',
        ];
    }
}