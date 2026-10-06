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
            'site_name'  => ['required', 'string', 'max:150'],
            'logo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096', 'dimensions:max_width=6000,max_height=6000'],
            'since_year' => ['nullable', 'digits:4'],

            'whatsapp' => ['nullable', 'string', 'max:20'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'email'    => ['nullable', 'email', 'max:150'],

            'instagram_url' => ['nullable', 'string', 'max:100'],
            'facebook_url'  => ['nullable', 'string', 'max:100'],
            'youtube_url'   => ['nullable', 'string', 'max:100'],
            'tiktok_url'    => ['nullable', 'string', 'max:100'],

            'address'                => ['nullable', 'string', 'max:255'],
            'map_embed_url'          => ['nullable', 'url', 'max:2000'],
            'opening_hours_weekday'  => ['nullable', 'string', 'max:100'],
            'opening_hours_weekend'  => ['nullable', 'string', 'max:100'],

            'about_title'       => ['nullable', 'string', 'max:150'],
            'about_description' => ['nullable', 'string', 'max:10000'],
            'about_photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'classes_section_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'pool_section_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'pool_section_title' => ['nullable', 'string', 'max:150'],
            'pool_section_description' => ['nullable', 'string', 'max:1000'],
            'join_cta_photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'join_cta_title'       => ['nullable', 'string', 'max:150'],
            'join_cta_description' => ['nullable', 'string', 'max:1000'],
            'gallery_header_type'  => ['required', 'in:photo,video'],
            'gallery_header_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'gallery_header_youtube_url' => [
                'nullable', 'string', 'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/',
            ],
            'event_header_type'  => ['required', 'in:photo,video'],
            'event_header_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'event_header_youtube_url' => [
                'nullable', 'string', 'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/',
            ],
            'team_header_type'  => ['required', 'in:photo,video'],
            'team_header_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'team_header_youtube_url' => [
                'nullable', 'string', 'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/',
            ],
            'join_header_type'  => ['required', 'in:photo,video'],
            'join_header_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'],
            'join_header_youtube_url' => [
                'nullable', 'string', 'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'site_name.required' => 'Nama situs wajib diisi.',
            'logo.image'         => 'Logo harus berupa gambar.',
            'logo.mimes'         => 'Format logo harus JPG, PNG, WEBP, atau SVG.',
            'logo.max'           => 'Ukuran logo maksimal 4MB.',
            'email.email'        => 'Format email tidak valid.',
            'instagram_url.max'  => 'Username Instagram maksimal 100 karakter.',
            'facebook_url.max'   => 'Username Facebook maksimal 100 karakter.',
            'youtube_url.max'    => 'Username YouTube maksimal 100 karakter.',
            'tiktok_url.max'     => 'Username TikTok maksimal 100 karakter.',
            'map_embed_url.url'  => 'Link embed Google Maps harus berupa URL yang valid.',
            'about_photo.max'    => 'Ukuran foto About Us maksimal 8MB.',
            'classes_section_photo.max' => 'Ukuran foto background section Kelas maksimal 8MB.',
            'pool_section_photo.max' => 'Ukuran foto background section kolam maksimal 8MB.',
            'join_cta_photo.max' => 'Ukuran foto background kartu "Gabung Bersama Kami" maksimal 8MB.',
            'join_cta_photo.image' => 'File background kartu "Gabung Bersama Kami" harus berupa gambar.',
            'gallery_header_type.required' => 'Pilih dulu jenis background header Galeri: Foto atau Video.',
            'gallery_header_photo.max' => 'Ukuran foto header Galeri maksimal 8MB.',
            'gallery_header_youtube_url.regex' => 'Link harus berupa URL YouTube yang valid (youtube.com atau youtu.be).',
            'event_header_type.required' => 'Pilih dulu jenis background header Acara: Foto atau Video.',
            'event_header_photo.max' => 'Ukuran foto header Acara maksimal 8MB.',
            'event_header_youtube_url.regex' => 'Link harus berupa URL YouTube yang valid (youtube.com atau youtu.be).',
            'team_header_type.required' => 'Pilih dulu jenis background header Atlet/Pelatih: Foto atau Video.',
            'team_header_photo.max' => 'Ukuran foto header Atlet/Pelatih maksimal 8MB.',
            'team_header_youtube_url.regex' => 'Link harus berupa URL YouTube yang valid (youtube.com atau youtu.be).',
            'join_header_type.required' => 'Pilih dulu jenis background header Join Us: Foto atau Video.',
            'join_header_photo.max' => 'Ukuran foto header Join Us maksimal 8MB.',
            'join_header_youtube_url.regex' => 'Link harus berupa URL YouTube yang valid (youtube.com atau youtu.be).',
        ];
    }
}
