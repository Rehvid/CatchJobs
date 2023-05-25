<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border px-6 py-6 ">
    @if(isset($company->industry))
        <div class="flex justify-between">
            <span class="font-bold">{{ __('company.industry.label') }}</span>
            <span class="text-gray-500">{{ $company->industry->name }}</span>
        </div>
    @endif
    @if(isset($company->employees))
        <div class="flex justify-between my-4">
            <span class="font-bold">{{ __('company.employees.show') }}</span>
            <span class="text-gray-500">{{ $company->employees }}</span>
        </div>
    @endif
    @if(isset($company->foundation_year))
        <div class="flex justify-between my-4">
            <span class="font-bold">{{ __('company.foundation_year.label') }}</span>
            <span class="text-gray-500">{{ $company->foundation_year }}</span>
        </div>
    @endif
    @if($company->socials->isNotEmpty())
        <div class="flex justify-between my-4 items-center">
            <span class="font-bold">{{ __('company.socials') }}</span>
            <ul class="flex">
                @foreach($company->socials as $social)
                    @if($social->socialNetwork->name !== 'website')
                        <li class="px-2">
                            <x-social-link url="{{$social->url}}" name="{{$social->socialNetwork->name}}" />
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>
@if (isset($company->location))
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border px-6 py-6 my-6 ">
        <div class="flex justify-between">
            <span class="font-bold">{{ __('location.province.label') }}</span>
            <span class="text-gray-500">{{ $company->location->province}}</span>
        </div>
        <div class="flex justify-between my-4">
            <span class="font-bold">{{ __('location.city.label') }} </span>
            <span class="text-gray-500">{{ $company->location->city }}</span>
        </div>
        <div class="flex justify-between my-4">
            <span class="font-bold">{{ __('location.street.label') }} </span>
            <span class="text-gray-500">{{ $company->location->street }}</span>
        </div>
        <div class="flex justify-between my-4">
            <span class="font-bold">{{ __('location.phone.label') }}</span>
            <span class="text-gray-500">{{ $company->location->phone }}</span>
        </div>
        <div class="flex justify-between my-4">
            <span class="font-bold">{{ __('location.email.label') }} </span>
            <span class="text-gray-500">{{ $company->location->email }}</span>
        </div>
@endif
