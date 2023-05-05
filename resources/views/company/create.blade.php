<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6" style="max-width:768px;">
            <form class="flex flex-wrap mb-6 p-4 sm:p-8 bg-white shadow sm:rounded-lg" method="post" action="{{ route('companies.store') }}">
                @csrf

                <div class="w-full">
                    @include('company.partials.company-inputs')
                </div>

                <div class="flex items-center gap-4 px-4">
                    <x-primary-button class="w-full bordered-full">{{ __('Save') }}</x-primary-button>
                </div>
            </form>


        </div>
    </div>
</x-app-layout>
