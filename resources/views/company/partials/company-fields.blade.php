<div class="w-full px-4 mb-8">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('company.create_title') }}
    </h2>
</div>


<div class="w-full px-4 mb-8">
    <x-input-label class="required" for="name" :value="__('company.name.label') " />
    <x-text-input
        id="name"
        class="block mt-1 w-full"
        type="text"
        name="name"
        value="{{ old('name', $company->name ?? '') }}"
        required
        autofocus
        autocomplete="name"
        placeholder="{{ __('company.name.placeholder') }}"
    />
    <x-input-error :messages="$errors->get('name')" class="mt-1" />
</div>

<div class="w-full px-4 mb-8">
    <x-input-label for="vat_number" :value="__('company.vat_number.label')" />
    <x-text-input
        id="vat_number"
        class="block mt-1 w-full"
        type="number"
        name="vat_number"
        value="{{ old('vat_number', $company->vat_number ?? '')}}"
        placeholder="{{__('company.vat_number.placeholder')}}"
        required
        autofocus
        autocomplete="name" />
    <x-input-error :messages="$errors->get('vat_number')" class="mt-1" />
</div>

<div class="w-full px-4 mb-8">
    <x-input-label  for="description" :value="__('company.description.label')" optional="true" />
    <textarea
        class="js-textarea"
        id="description"
        name="description">{{ old('description', $company->description ?? '') }}
    </textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-1" />
</div>


<div class="w-full px-4 mb-8">
    <x-input-label for="employees" :value="__('company.employees.label')" optional="true" />
    <input type="hidden" class="old_employees" value="{{old('employees', $company->employees ?? '')}}">
    <x-select name="employees" id="employees">
        <option>1 - 5</option>
        <option>5 - 10</option>
        <option>10 - 25</option>
        <option>25 - 50</option>
        <option>50 - 100</option>
        <option>100 - 200</option>
        <option>200 - 500</option>
        <option>500+</option>
    </x-select>
    <x-input-error :messages="$errors->get('employees')" class="mt-1" />
</div>

<div class="w-full px-4 mb-8">
    <x-input-label  for="foundation_year" :value="__('company.foundation_year.label')" optional="true" />
    <x-text-input
        id="foundation_year"
        class="block mt-1 w-full"
        type="number"
        name="foundation_year"
        value="{{ old('foundation_year', $company->foundation_year ?? '')}}"
        placeholder="{{__('company.foundation_year.placeholder')}}"
        autofocus
        autocomplete="off"
    />
    <x-input-error :messages="$errors->get('foundation_year')" class="mt-1" />
</div>



<div class="w-full px-4 mb-8">
    <x-input-label  for="benefits" :value="__('company.benefits.label')" optional="true" />
    <x-text-input
        data-url="{{ route('benefits') }}"
        id="benefits"
        class="block mt-1 w-full js-benefit js-arrow"
        type="text"
        name="benefits"
        value="{{ old('benefits', isset($company) === true ? $company->benefits->implode('name', ',') : '') }}"
        autocomplete="off"
    />
    <x-input-error :messages="$errors->get('benefits')" class="mt-1" />
    @foreach($errors->all() as $key => $error)
        @if(Str::contains($error, 'benefit'))
            <x-input-error :messages="$error" class="mt-1" />
        @endif
    @endforeach
</div>

<div class="w-full px-4 mb-8">

    <x-input-label for="industry" :value="__('company.industry.label')" optional="true" />
    <x-text-input
        data-url="{{ route('industries') }}"
        id="industry"
        class="block mt-1 w-full js-industry js-arrow"
        data-max-items="1"
        type="text"
        name="industry"
        value="{{ old('industry', $company->industry->name ?? '')  }}"
        autocomplete="off"
    />
    <x-input-error :messages="$errors->get('industry')" class="mt-1" />
</div>

