<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJoinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'age'      => ['nullable', 'integer', 'min:1', 'max:100'],
            'gender'   => ['nullable', 'in:Laki-laki,Perempuan'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'email'    => ['required', 'email', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'message'  => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi supaya kami bisa menghubungi Anda.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
        ];
    }
}