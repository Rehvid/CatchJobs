<?php
namespace App\Http\Requests;

use App\Models\Company;
use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use JsonException;
use function PHPUnit\Framework\isNull;

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
            'industry' => ['nullable', 'string', 'min:2', 'max:255'],
            'location_id' => ['nullable','integer','min:0'],
            'alias' => ['sometimes', 'nullable', 'string', 'min:2', 'max:255'],
            'postcode' => ['sometimes', 'required', 'string', 'regex:/^[0-9]{2}-[0-9]{3}/', 'size:6'],
            'province' => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'city' => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'street' => ['sometimes', 'required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z0-9\s\/-]+$/'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'min:2',
                'max:255',
                Rule::unique('locations')
                    ->where(fn ($query) => $query->whereNot('user_id', $this->user()->id))
            ],
            'phone' => [
                'sometimes',
                'required',
                'numeric',
                'min_digits:9',
                'max_digits:15',
                Rule::unique('locations')
                    ->where(fn ($query) => $query->whereNot('user_id', $this->user()->id))
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
                    ->max(4 * 1024)
            ],
            'image_cover' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(4 * 1024)
            ],
            'image_gallery' => ['nullable', 'array'],
            'image_gallery.*' => [
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(4 * 1024)
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
