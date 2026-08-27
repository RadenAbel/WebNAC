<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category'    => ['required', 'string', 'max:100'],
            'days'        => ['required', 'array', 'min:1'],
            'days.*'      => ['in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'time_start'  => ['required', 'date_format:H:i'],
            'time_end'    => ['required', 'date_format:H:i', 'after:time_start'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.required'   => 'Kategori wajib diisi (mis. Junior, Senior, Swim Class A).',
            'days.required'       => 'Pilih minimal 1 hari latihan.',
            'time_start.required' => 'Jam mulai wajib diisi.',
            'time_end.required'   => 'Jam selesai wajib diisi.',
            'time_end.after'      => 'Jam selesai harus lebih besar dari jam mulai.',
        ];
    }
}