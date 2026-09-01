<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:200'],
            'photo'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'event_date'  => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'pdf_report'  => ['required', 'file', 'mimes:pdf', 'max:10240'], // maks 10MB
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'Nama acara wajib diisi.',
            'photo.required'      => 'Foto acara wajib diupload.',
            'photo.mimes'         => 'Format foto harus JPG, PNG, atau WEBP.',
            'photo.max'           => 'Ukuran foto maksimal 3MB.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'pdf_report.required' => 'Laporan PDF wajib diupload.',
            'pdf_report.mimes'    => 'Laporan harus berformat PDF.',
            'pdf_report.max'      => 'Ukuran laporan PDF maksimal 10MB.',
        ];
    }
}