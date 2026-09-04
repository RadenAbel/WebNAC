<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberAchievementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:200'],
            'year'        => ['nullable', 'digits:4'],
            'country'     => ['nullable', 'string', 'size:2', 'in:' . implode(',', array_keys(config('countries')))],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul pencapaian/penghargaan wajib diisi.',
            'year.digits'     => 'Tahun harus 4 digit, mis. 2024.',
            'country.in'      => 'Negara yang dipilih tidak valid.',
        ];
    }
}