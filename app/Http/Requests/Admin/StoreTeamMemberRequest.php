<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Semua yang sampai sini sudah lolos middleware 'auth' di route,
        // jadi otomatis diizinkan (tidak perlu pengecekan role tambahan
        // karena sistem ini cuma punya 1 level admin).
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:255'],
            'photo'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // maks 2MB
            'role'   => ['required', 'in:pelatih,atlet'],
            'category' => ['nullable', 'string', 'in:Junior,Senior,Swim Class A,Swim Class B,Head Coach,Assistant Coach,Fitness Coach'],
            'swim_style' => ['nullable', 'string', 'in:Gaya Bebas,Gaya Dada,Gaya Punggung,Gaya Kupu-Kupu,Gaya Ganti (Individual Medley),Serba Bisa (All-Round)'],
            'age'    => ['nullable', 'integer', 'min:1', 'max:100'],
            'birth_date'  => ['nullable', 'date', 'before_or_equal:today'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'join_date'   => ['nullable', 'date', 'before_or_equal:today'],

            'whatsapp'       => ['nullable', 'string', 'max:20'],
            'instagram_url'  => ['nullable', 'url', 'max:255'],
            'facebook_url'   => ['nullable', 'url', 'max:255'],
            'tiktok_url'     => ['nullable', 'url', 'max:255'],

            'origin_city'        => ['nullable', 'string', 'max:100'],
            'years_experience'   => ['nullable', 'integer', 'min:0', 'max:80'],
            'total_medals'       => ['nullable', 'integer', 'min:0'],
            'total_achievements' => ['nullable', 'integer', 'min:0'],

            'bio'        => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Nama wajib diisi.',
            'role.required'   => 'Pilih peran: Pelatih atau Atlet.',
            'category.in'     => 'Kategori yang dipilih tidak valid.',
            'swim_style.in'   => 'Gaya spesialis yang dipilih tidak valid.',
            'photo.image'     => 'File harus berupa gambar.',
            'photo.mimes'     => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'       => 'Ukuran foto maksimal 2MB.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
            'join_date.before_or_equal'  => 'Tanggal bergabung tidak boleh di masa depan.',
            'instagram_url.url' => 'Link Instagram harus berupa URL yang valid (mis. https://instagram.com/username).',
            'facebook_url.url'  => 'Link Facebook harus berupa URL yang valid.',
            'tiktok_url.url'    => 'Link TikTok harus berupa URL yang valid.',
        ];
    }
}