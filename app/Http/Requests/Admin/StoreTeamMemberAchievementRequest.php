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
            'event_date'  => ['nullable', 'date', 'before_or_equal:today'],
            'country'     => ['nullable', 'string', 'size:2', 'in:' . implode(',', array_keys(config('countries')))],
            'total_gold'   => ['nullable', 'integer', 'min:0'],
            'total_silver' => ['nullable', 'integer', 'min:0'],
            'total_bronze' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Judul pencapaian/penghargaan wajib diisi.',
            'year.digits'       => 'Tahun harus 4 digit, mis. 2024.',
            'event_date.before_or_equal' => 'Tanggal pertandingan tidak boleh di masa depan.',
            'country.in'        => 'Negara yang dipilih tidak valid.',
        ];
    }
}