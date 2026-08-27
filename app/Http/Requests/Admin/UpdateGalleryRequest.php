<?php

namespace App\Http\Requests\Admin;

class UpdateGalleryRequest extends StoreGalleryRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['image'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'];

        return $rules;
    }
}