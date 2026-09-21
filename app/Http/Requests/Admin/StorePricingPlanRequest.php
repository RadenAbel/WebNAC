<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePricingPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:100'],
            'description'      => ['nullable', 'string', 'max:255'],
            'price'            => ['required', 'integer', 'min:0'],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:100'],
            'features'         => ['nullable', 'string', 'max:2000'],
            'is_highlighted'   => ['nullable', 'boolean'],
            'is_active'        => ['nullable', 'boolean'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'            => 'Nama paket wajib diisi.',
            'price.required'            => 'Harga wajib diisi.',
            'price.integer'             => 'Harga harus berupa angka (tanpa titik/koma).',
            'discount_percent.min'      => 'Diskon minimal 1%.',
            'discount_percent.max'      => 'Diskon maksimal 100%.',
        ];
    }
}