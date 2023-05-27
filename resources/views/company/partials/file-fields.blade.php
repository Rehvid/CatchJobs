<div class="w-full px-4 mb-8">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('company.media_title') }}
    </h2>
</div>


<div class="p-6 space-y-6 ">
    @if(isset($company) && $company->fileByCollection('logo'))
        <div class="relative max-w-[100px]">
            <img class="rounded-full"
                 src="{{ $company->fileByCollection('logo')->getPublicPath() }}"
                 alt="logo"
            />
            <a class="js-remove-image"
               data-url="{{route('companies.destroy_image')}}"
               data-image-id="{{$company->fileByCollection('logo')->id}}"
               data-company-id="{{$company->id}}"
               data-max-reached="true"
            >
            </a>
        </div>
    @endif
    <x-input-label :value="__('company.logo.label')" for="logo"/>
    <x-text-input
        id="logo"
        type="file"
        class="{{isset($company) && $company->fileByCollection('logo') ? 'input-file input-file--hidden' : '' }}
            block
            mt-1
            w-full
            "
        name="image_logo"
        value="{{old('image_logo')}}"
    />
        <span class="text-gray-500 text-sm my-2" >{{ __('company.logo.comment') }}</span>
    <x-input-error :messages="$errors->get('image_logo')" class="mt-1"/>

</div>


<div class="p-6 space-y-6 ">
    @if(isset($company) && $company->fileByCollection('cover'))
        <div class="relative">
            <img
                class="w-full"
                src="{{ $company->fileByCollection('cover')->getPublicPath() }}"
                alt="cover"
            />
            <a class="js-remove-image"
               data-url="{{route('companies.destroy_image')}}"
               data-image-id="{{$company->fileByCollection('cover')->id}}"
               data-company-id="{{$company->id}}"
               data-max-reached="true"
            >
            </a>
        </div>
    @endif
    <x-input-label :value="__('company.cover.label')" for="cover"/>
    <x-text-input
        id="cover"
        type="file"
        class="block mt-1 w-full {{isset($company) && $company->fileByCollection('cover') ? 'input-file input-file--hidden' : '' }}"
        name="image_cover"
        value="{{old('image_cover')}}"
    />
        <span class="text-gray-500 text-sm my-2">{{ __('company.cover.comment') }}</span>
    <x-input-error :messages="$errors->get('image_cover')" class="mt-1"/>
</div>

<div class="p-6 space-y-6 ">
    @if(isset($company) && !empty($company->getGalleryImages()))
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($company->getGalleryImages() as $image)
                <div class="relative">
                    <img class="h-auto max-w-full rounded-lg" src="{{$image->getPublicPath()}}" alt="gallery">
                    <a class="js-remove-image"
                       data-url="{{route('companies.destroy_image')}}"
                       data-image-id="{{$image->id}}"
                       data-company-id="{{$company->id}}"
                    >
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    <x-input-label :value="__('company.gallery.label')" for="gallery"/>
    <x-text-input
        multiple
        id="gallery"
        type="file"
        class="block mt-1 w-full"
        name="image_gallery[]"
        value="{{old('image_gallery')}}"
    />
        <span class="text-gray-500 text-sm my-2">{{ __('company.gallery.comment') }}</span>
    <x-input-error :messages="$errors->get('image_gallery')" class="mt-1"/>
</div>
