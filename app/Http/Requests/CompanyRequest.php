<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use JsonException;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->routeIs('companies.store')) {
            return $this->user()->can('create', Company::class);
        }

        if ($this->routeIs('companies.update')) {
            return $this->user()->can('update', Company::class);
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:'.Company::class],
            'vat_number' => ['required', 'string', 'size:10', 'unique:'.Company::class],
            'description' => ['nullable', 'string', 'max:1000'],
            'employees' => ['nullable', 'string'],
            'foundation_year' => ['nullable', 'integer', 'digits:4', 'gt:0'],
            'benefits' => ['nullable', 'array'],
            'benefits.*.value' => ['required','string', 'min:2','max:255'],
            'industry' => ['nullable', 'string', 'min:2', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'benefits.*.value' => 'The benefit must be string'
        ];
    }


    protected function prepareForValidation(): void
    {
        if ($this->benefits && Str::isJson($this->benefits)) {
            try {
               $this->merge([
                   'benefits' => json_decode($this->benefits, true, 512, JSON_THROW_ON_ERROR),
               ]);
            } catch (JsonException) {
                throw ValidationException::withMessages(['benefits' => __('validation.wrong_syntax')]);
            }
         }
    }
}
