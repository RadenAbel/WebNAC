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
            'photo_is_cutout' => ['nullable', 'boolean'],
            'role'   => ['required', 'in:pelatih,atlet'],
            'category' => ['nullable', 'string', 'in:Novato,Avance,Campeón'],
            'school_name' => ['nullable', 'string', 'max:150'], // khusus atlet
            'swim_style'   => ['nullable', 'array'],
            'swim_style.*' => ['string', 'in:Gaya Bebas,Gaya Dada,Gaya Punggung,Gaya Kupu-Kupu,Gaya Ganti (Individual Medley),Serba Bisa (All-Round)'],
            'age'    => ['nullable', 'integer', 'min:1', 'max:100'],
            'birth_date'  => ['nullable', 'date', 'before_or_equal:today'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'gender'      => ['nullable', 'string', 'in:Laki-Laki,Perempuan'],
            'height_cm'   => ['nullable', 'integer', 'min:0', 'max:250'],
            'weight_kg'   => ['nullable', 'integer', 'min:0', 'max:250'],
            'join_date'   => ['nullable', 'date', 'before_or_equal:today'],

            'whatsapp'       => ['nullable', 'string', 'max:20'],
            'instagram_url'  => ['nullable', 'string', 'max:100'],
            'facebook_url'   => ['nullable', 'string', 'max:100'],
            'tiktok_url'     => ['nullable', 'string', 'max:100'],

            'origin_city'        => ['nullable', 'string', 'max:100'],
            'years_experience'   => ['nullable', 'integer', 'min:0', 'max:80'],
            'total_medals'       => ['nullable', 'integer', 'min:0'],

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
            'swim_style.*.in' => 'Ada gaya spesialis yang dipilih tidak valid.',
            'gender.in'       => 'Gender yang dipilih tidak valid.',
            'height_cm.max'   => 'Tinggi badan tidak valid.',
            'weight_kg.max'   => 'Berat badan tidak valid.',
            'photo.image'     => 'File harus berupa gambar.',
            'photo.mimes'     => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'       => 'Ukuran foto maksimal 2MB.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
            'join_date.before_or_equal'  => 'Tanggal bergabung tidak boleh di masa depan.',
            'instagram_url.max' => 'Username Instagram maksimal 100 karakter.',
            'facebook_url.max'  => 'Username Facebook maksimal 100 karakter.',
            'tiktok_url.max'    => 'Username TikTok maksimal 100 karakter.',
        ];
    }
}