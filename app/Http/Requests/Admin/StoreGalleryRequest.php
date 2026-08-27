<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'      => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'caption'    => ['nullable', 'string', 'max:150'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Foto galeri wajib diupload.',
            'image.image'    => 'File harus berupa gambar.',
            'image.mimes'    => 'Format foto harus JPG, PNG, atau WEBP.',
            'image.max'      => 'Ukuran foto maksimal 3MB.',
        ];
    }
}