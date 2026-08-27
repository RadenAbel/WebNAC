<?php

namespace App\Http\Requests\Admin;

class UpdateSliderRequest extends StoreSliderRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        // Saat update, foto boleh tidak diupload ulang (pakai foto lama)
        $rules['image'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'];

        return $rules;
    }
}