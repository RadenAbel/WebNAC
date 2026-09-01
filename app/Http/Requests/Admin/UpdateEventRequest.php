<?php

namespace App\Http\Requests\Admin;

class UpdateEventRequest extends StoreEventRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        // Saat update, foto & PDF boleh tidak diupload ulang (pakai file lama)
        $rules['photo']      = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'];
        $rules['pdf_report'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];

        return $rules;
    }
}