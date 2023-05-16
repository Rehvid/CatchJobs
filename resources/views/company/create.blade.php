<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6" style="max-width:768px;">
            <form
                class="flex flex-wrap mb-6 p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                method="post"
                action="{{ route('companies.store') }}"
                enctype="multipart/form-data"
            >
                @csrf


                <div class="w-full">
                    @include('company.partials.company-inputs')
                </div>

                <div class="w-full lg:mt-10">
                    @include('company.partials.location-inputs', ['locations' => $locations])
                </div>

                <div class="w-full lg:mt-10">
                    @include('company.partials.social-fields')
                </div>

                <div class="w-full lg:mt-10 lg:mb-10">
                    @include('company.partials.file-fields')
                </div>



                <div class="flex items-center gap-4 px-4">
                    <x-primary-button class="w-full bordered-full">{{ __('company.create') }}</x-primary-button>
                </div>



            </form>


        </div>
    </div>
    @vite('resources/js/company.js')
    @vite('resources/css/tagify.css')
</x-app-layout>
