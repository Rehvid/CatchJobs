<?php
namespace App\Http\Requests\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
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
            return $this->user()->can('update', $this->company);
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('companies', 'name')->ignore($this->route('company'), $this->id)
            ],
            'vat_number' => [
                'required',
                'string',
                'size:10',
                Rule::unique('companies', 'vat_number')->ignore($this->route('company'), $this->id)
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'employees' => ['nullable', 'string'],
            'foundation_year' => ['nullable', 'integer', 'digits:4', 'gt:0'],
            'benefits' => ['nullable', 'array'],
            'benefits.*.value' => ['required','string', 'min:2','max:255'],
            'industry' => ['nullable', 'string', 'min:2', 'max:255'],
            'location_id' => ['nullable','integer','min:0'],
            'alias' => ['sometimes', 'nullable', 'string', 'min:2', 'max:255'],
            'postcode' => ['sometimes', 'required', 'string', 'regex:/^[0-9]{2}-[0-9]{3}/', 'size:6'],
            'province' => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'city' => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'street' => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'min:2',
                'max:255',
                Rule::unique('locations', 'email')->ignore($this->location_id)
            ],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'min:9',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('locations','phone')->ignore($this->location_id)
            ],
            'facebook' => ['nullable',  'min:2', 'max:255', 'url'],
            'instagram' => ['nullable',  'min:2', 'max:255', 'url'],
            'twitter' => ['nullable',  'min:2', 'max:255', 'url'],
            'website' => ['nullable',  'min:2', 'max:255', 'url'],
            'linkedin' => ['nullable', 'min:2', 'max:255', 'url'],
            'image_logo' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(1024)
                    ->dimensions(Rule::dimensions()->maxWidth(100)->maxHeight(100))
            ],
            'image_cover' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(2 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(1200)->maxHeight(400))
            ],
            'image_gallery' => ['nullable', 'array'],
            'image_gallery.*' => [
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(1024)
                    ->dimensions(Rule::dimensions()->maxWidth(540)->maxHeight(360))
            ]

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

        if (!is_null($this->location_id)) {
            $this->merge([
                'location_id' => (int) $this->location_id
            ]);
        }

    }
}
