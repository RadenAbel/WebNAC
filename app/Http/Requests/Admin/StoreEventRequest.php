<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:200'],
            'photo'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'event_date'  => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'location'    => ['nullable', 'string', 'max:150'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'Nama kejuaraan wajib diisi.',
            'photo.required'      => 'Foto acara wajib diupload.',
            'photo.mimes'         => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'           => 'Ukuran foto maksimal 8MB.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
        ];
    }
}
