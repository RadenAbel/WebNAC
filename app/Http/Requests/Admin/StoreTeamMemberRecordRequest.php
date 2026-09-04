<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event'         => ['required', 'string', 'max:150'], // Nomor, mis. "50m Gaya Bebas"
            'time'          => ['required', 'string', 'max:30'],  // Waktu, mis. "24.50"
            'medal'         => ['nullable', 'string', 'max:30'],
            'pool_length'   => ['nullable', 'integer', 'in:25,50'],
            'age_at_record' => ['nullable', 'integer', 'min:1', 'max:100'],
            'competition'   => ['nullable', 'string', 'max:150'],
            'country'       => ['nullable', 'string', 'size:2', 'in:' . implode(',', array_keys(config('countries')))],
            'record_date'   => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'event.required' => 'Nomor/gaya renang wajib diisi (mis. 50m Gaya Bebas).',
            'time.required'  => 'Waktu wajib diisi.',
            'pool_length.in' => 'Panjang kolam hanya boleh 25 atau 50 meter.',
            'country.in'     => 'Negara yang dipilih tidak valid.',
        ];
    }
}