<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'id' => 'required|integer|exists:locations'
        ];
    }

    protected function  prepareForValidation(): void
    {
        $this->merge([
            'id' => (int) $this->route()->parameter('id')
        ]);
    }
}
