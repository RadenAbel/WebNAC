<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pengecekan utama (siapa yang boleh sampai ke sini) sudah
        // dilakukan middleware EnsureSuperAdmin di route — ini cuma
        // lapisan jaga-jaga tambahan.
        return $this->user()?->isSuperAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'string', 'in:admin,super_admin'],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'in:' . implode(',', array_keys(config('admin_sections')))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah dipakai akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role.required'     => 'Pilih role akun ini.',
            'role.in'           => 'Role yang dipilih tidak valid.',
        ];
    }
}