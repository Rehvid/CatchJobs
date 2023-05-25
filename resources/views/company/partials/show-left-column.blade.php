@if ($company->fileByCollection('cover'))
    <img class="company-cover" src="{{ $company->fileByCollection('cover')->getPublicPath() }}" alt="cover"/>
@endif

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border px-6 py-6 my-6">
    <div class="flex">
        @if ($company->fileByCollection('logo'))
            <img class="rounded-full w-16 h-16"
                 src="{{ $company->fileByCollection('logo')->getPublicPath() }}"
                 alt="logo"/>
        @else
            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-slate-100 ">
                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                     className="w-6 h-6">
                    <path strokeLinecap="round" strokeLinejoin="round"
                          d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                    <path strokeLinecap="round" strokeLinejoin="round"
                          d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                </svg>
            </div>
        @endif
        <div class="pl-4 flex justify-between items-center w-full">
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white py-2">{{ $company->name }}</h5>
            @if($company->getWebsiteSocial())
                <x-social-link
                    url="{{$company->getWebsiteSocial()->url}}"
                    name="{{$company->getWebsiteSocial()->socialNetwork->name}}"
                >
                    {{ __('company.visit_website')}}
                </x-social-link>
            @endif
        </div>
    </div>
</div>

@if(isset($company->description))
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border px-6 py-6 my-6">
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white py-2">{{ __('company.description.label') }}</h5>
        <div>
            {!! clean($company->description) !!}
        </div>
    </div>
@endif

@if($company->benefits->isNotEmpty())
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border px-6 py-6 my-6">
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white py-2">{{ __('company.benefits.label') }}</h5>
        <div class="flex flex-wrap">
            @foreach($company->benefits as $benefit)
                <span
                    class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    {{ $benefit->name }}
                </span>
            @endforeach
        </div>
    </div>
@endif

@if($company->getGalleryImages()->isNotEmpty())
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border px-6 py-6 my-6">
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white py-2">{{ __('company.gallery.label') }}</h5>
        <div class="company-grid-gallery ">

            @foreach($company->getGalleryImages() as $galleryImage)
                <img class="company-gallery"
                     src="{{ $galleryImage->getPublicPath() }}"
                     alt="gallery"/>
            @endforeach
        </div>
    </div>
@endif

