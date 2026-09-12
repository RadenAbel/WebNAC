<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Identitas
            'site_name'  => ['required', 'string', 'max:150'],
            'logo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'since_year' => ['nullable', 'digits:4'],

            // Kontak perusahaan
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'email'    => ['nullable', 'email', 'max:150'],

            // Sosial media perusahaan
            'instagram_url' => ['nullable', 'string', 'max:100'],
            'facebook_url'  => ['nullable', 'string', 'max:100'],
            'youtube_url'   => ['nullable', 'string', 'max:100'],
            'tiktok_url'    => ['nullable', 'string', 'max:100'],

            // Lokasi & jam
            'address'                => ['nullable', 'string', 'max:255'],
            'map_embed_url'          => ['nullable', 'url', 'max:2000'],
            'opening_hours_weekday'  => ['nullable', 'string', 'max:100'],
            'opening_hours_weekend'  => ['nullable', 'string', 'max:100'],

            // About Us
            'about_title'       => ['nullable', 'string', 'max:150'],
            'about_description' => ['nullable', 'string', 'max:2000'],
            'about_photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    public function messages(): array
    {
        return [
            'site_name.required' => 'Nama situs wajib diisi.',
            'logo.image'         => 'Logo harus berupa gambar.',
            'logo.mimes'         => 'Format logo harus JPG, PNG, WEBP, atau SVG.',
            'logo.max'           => 'Ukuran logo maksimal 1MB.',
            'email.email'        => 'Format email tidak valid.',
            'instagram_url.max'  => 'Username Instagram maksimal 100 karakter.',
            'facebook_url.max'   => 'Username Facebook maksimal 100 karakter.',
            'youtube_url.max'    => 'Username YouTube maksimal 100 karakter.',
            'tiktok_url.max'     => 'Username TikTok maksimal 100 karakter.',
            'map_embed_url.url'  => 'Link embed Google Maps harus berupa URL yang valid.',
            'about_photo.max'    => 'Ukuran foto About Us maksimal 3MB.',
        ];
    }
}