<?php

namespace App\Http\Requests\Admin;

class UpdateGalleryRequest extends StoreGalleryRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['image'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'];

        return $rules;
    }
}
