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
            'type'        => ['required', 'in:photo,video'],
            // Wajib saat tambah baru KHUSUS type=photo, tapi di UpdateSliderRequest
            // kita override jadi 'nullable' (lihat class itu) karena saat edit,
            // foto lama boleh dipertahankan tanpa upload ulang.
            'image'       => ['required_if:type,photo', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'youtube_url' => [
                'required_if:type,video', 'nullable', 'string', 'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/',
            ],
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
            'type.required'   => 'Pilih dulu jenis background-nya: Foto atau Video.',
            'image.required_if' => 'Foto slider wajib diupload untuk jenis Foto.',
            'image.image'     => 'File harus berupa gambar.',
            'image.mimes'     => 'Format foto harus JPG, PNG, atau WEBP.',
            'image.max'       => 'Ukuran foto maksimal 3MB.',
            'youtube_url.required_if' => 'Link YouTube wajib diisi untuk jenis Video.',
            'youtube_url.regex'       => 'Link harus berupa URL YouTube yang valid (youtube.com atau youtu.be).',
        ];
    }
}