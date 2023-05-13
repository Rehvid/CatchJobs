<div class="w-full px-4 mb-8">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('company.social_title') }}
    </h2>
</div>

<div class="w-full px-4 mb-8">
    <x-input-label for="facebook" :value="__('company.facebook.label')" optional="true" />
    <x-text-input
        id="facebook"
        class="block mt-1 w-full"
        type="text"
        name="facebook"
        value="{{ old('facebook', $company->location->facebook ?? '') }}"
        autofocus
        autocomplete="name"

    />
    <x-input-error :messages="$errors->get('facebook')" class="mt-1 " />
</div>

<div class="w-full px-4 mb-8">
    <x-input-label for="instagram" :value="__('company.instagram.label')" optional="true" />
    <x-text-input
        id="instagram"
        class="block mt-1 w-full"
        type="text"
        name="instagram"
        value="{{ old('instagram', $company->location->instagram ?? '') }}"
        autofocus
        autocomplete="name"
    />
    <x-input-error :messages="$errors->get('instagram')" class="mt-1 " />
</div>

<div class="w-full px-4 mb-8">
    <x-input-label for="twitter" :value="__('company.twitter.label')" optional="true" />
    <x-text-input
        id="twitter"
        class="block mt-1 w-full"
        type="text"
        name="twitter"
        value="{{ old('twitter', $company->location->twitter ?? '') }}"
        autofocus
        autocomplete="name"
    />
    <x-input-error :messages="$errors->get('twitter')" class="mt-1 " />
</div>


<div class="w-full px-4 mb-8">
    <x-input-label for="website" :value="__('company.website.label')" optional="true" />
    <x-text-input
        id="website"
        class="block mt-1 w-full"
        type="text"
        name="website"
        value="{{ old('website', $company->location->website ?? '') }}"
        autofocus
        autocomplete="name"
    />
    <x-input-error :messages="$errors->get('website')" class="mt-1 " />
</div>

<div class="w-full px-4 mb-8">
    <x-input-label  for="linkedin" :value="__('company.linkedin.label')" optional="true" />
    <x-text-input
        id="linkedin"
        class="block mt-1 w-full"
        type="text"
        name="linkedin"
        value="{{ old('linkedin', $company->location->linkedin ?? '') }}"
        autofocus
        autocomplete="name"
    />
    <x-input-error :messages="$errors->get('linkedin')" class="mt-1 " />
</div>

