<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberLicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:200'],
            'issuer'           => ['nullable', 'string', 'max:150'],
            'license_number'   => ['nullable', 'string', 'max:100'],
            'issued_date'      => ['nullable', 'date'],
            'expiry_date'      => ['nullable', 'date', 'after_or_equal:issued_date'],
            'certificate_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // maks 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Nama lisensi/sertifikasi wajib diisi.',
            'expiry_date.after_or_equal' => 'Tanggal kedaluwarsa tidak boleh sebelum tanggal terbit.',
            'certificate_file.mimes' => 'Sertifikat harus berupa PDF, JPG, atau PNG.',
            'certificate_file.max'   => 'Ukuran file sertifikat maksimal 5MB.',
        ];
    }
}