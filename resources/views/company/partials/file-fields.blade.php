<div class="w-full px-4 mb-8">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('company.media_title') }}
    </h2>
</div>

<div class="p-6 space-y-6 ">
    <x-input-label :value="__('company.logo.label')" for="logo" />
    <x-text-input
        id="logo"
        type="file"
        class="block mt-1 w-full"
        name="image_logo"
        value="{{old('image_logo')}}"
    />
    <x-input-error :messages="$errors->get('image_logo')" class="mt-1" />
</div>

<div class="p-6 space-y-6 ">
    <x-input-label :value="__('company.cover.label')" for="cover" />
    <x-text-input
        id="cover"
        type="file"
        class="block mt-1 w-full"
        name="image_cover"
        value="{{old('image_cover')}}"
    />
    <x-input-error :messages="$errors->get('image_cover')" class="mt-1" />
</div>

<div class="p-6 space-y-6 ">
    <x-input-label :value="__('company.gallery.label')" for="gallery" />
    <x-text-input
        multiple
        id="gallery"
        type="file"
        class="block mt-1 w-full"
        name="image_gallery[]"
        value="{{old('image_gallery')}}"
    />
    <x-input-error :messages="$errors->get('image_gallery')" class="mt-1" />
</div>
