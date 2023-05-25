<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="company-detail">
            <div> @include('company.partials.show-left-column')</div>
            <div>@include('company.partials.show-right-column')</div>
        </div>
    </div>
    @vite('resources/css/company.css')
</x-app-layout>
