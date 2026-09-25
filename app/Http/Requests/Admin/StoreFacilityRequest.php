<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1500'],
            'highlights'  => ['nullable', 'string', 'max:1500'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama fasilitas wajib diisi.',
            'photo.image'   => 'File harus berupa gambar.',
            'photo.mimes'   => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'     => 'Ukuran foto maksimal 8MB.',
        ];
    }
}