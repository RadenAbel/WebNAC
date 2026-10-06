<?php

namespace App\Http\Requests\Admin;

class UpdateManagementMemberRequest extends StoreManagementMemberRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['photo'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000'];

        return $rules;
    }
}
