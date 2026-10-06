<?php

namespace App\Http\Requests\Admin;

use App\Models\EventResult;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'swim_event'     => ['required', 'string', 'max:100'],
            'age_group'      => ['nullable', 'string', 'max:50'],
            'gender'         => ['required', Rule::in(array_keys(EventResult::GENDERS))],
            'team_member_id' => ['nullable', 'integer', 'exists:team_members,id'],
            'athlete_name'   => ['required_without:team_member_id', 'nullable', 'string', 'max:150'],
            'school_name'    => ['nullable', 'string', 'max:150'],
            'birth_date'     => ['nullable', 'date', 'before:today'],
            'club'           => ['nullable', 'string', 'max:150'],
            'heat'           => ['nullable', 'integer', 'min:1', 'max:999'],
            'lane'           => ['nullable', 'integer', 'min:0', 'max:20'],
            'rank'           => ['nullable', 'integer', 'min:1', 'max:999'],
            'time'           => ['nullable', 'string', 'max:20', function ($attribute, $value, $fail) {
                if (EventResult::timeToSeconds($value) === null) {
                    $fail('Format waktu tidak valid. Contoh: 00:32.45 atau 01:05.20.');
                }
            }],
            'note'           => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'swim_event.required'              => 'Nomor lomba wajib dipilih.',
            'gender.required'                  => 'Jenis kelamin wajib dipilih.',
            'athlete_name.required_without'    => 'Pilih atlet NAC atau ketik nama atlet.',
            'birth_date.before'                => 'Tanggal lahir tidak valid.',
            'rank.min'                         => 'Peringkat minimal 1.',
            'heat.min'                         => 'Seri minimal 1.',
            'lane.max'                         => 'Lintasan maksimal 20.',
        ];
    }
}
