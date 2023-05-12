<div class="w-full px-4 mb-8">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('company.location_title') }}
    </h2>
</div>

<div class="accordion-container">
    <div class="w-full px-4 mb-8 flex">
        <input type="radio"
               class="accordion-radio mr-4"
               id="accordion-radio-default"
               name="location_id"
               value=""
               @if(old('location_id') === null) checked @endif
        />
        <x-input-label :value="__('location.radio.default')" for="accordion-radio-default" />
    </div>

    <div class="w-full px-4 mb-8 flex">
        <input
            type="radio"
            class="accordion-radio mr-4"
            name="location_id"
            id="accordion-radio-create"
            value="0"
            @if(old('location_id') === '0')
                checked
            @endif
        />
        <x-input-label  :value="__('location.radio.create')"  for="accordion-radio-create"/>
    </div>

    @foreach($locations as $location)
        <div class="w-full px-4 mb-8 flex">
            <input type="radio"
                   class="accordion-radio mr-4"
                   name="location_id"
                   id="accordion-radio-location-{{ $location->id }}"
                   data-location-id=" {{ $location->id }}"
                   data-url="{{route('locations.get', $location->id)}}"
                   @if((int) old('location_id') === $location->id) checked @endif
                   value="{{ $location->id }}"
            />
            <x-input-label class="flex flex-wrap"  for="accordion-radio-location-{{ $location->id }}">
                <strong> {{ $location->alias }} </strong>
                <span class="text-gray-500 pl-2 pr-2">{{ $location->city }},</span>
                <span class="text-gray-500 pr-2" >{{ $location->street }},</span>
                <span class="text-gray-500 pr-2">{{ $location->phone }}</span>
            </x-input-label>
        </div>

    @endforeach


    <div class="accordion">
        <div class="w-full px-4 mb-8">
            <x-input-label class="required" for="alias" :value="__('location.alias.label')" optional="true" />
            <x-text-input
                id="alias"
                class="block mt-1 w-full"
                type="text"
                name="alias"
                value="{{ old('alias', $company->location->alias ?? '') }}"
                autofocus
                autocomplete="name"
                placeholder="{{ __('location.alias.placeholder') }}"
            />
            <x-input-error :messages="$errors->get('alias')" class="mt-1 location-error" />
        </div>

        <div class="w-full px-4 mb-8">
            <x-input-label for="postcode" :value="__('location.postcode.label')" />
            <x-text-input
                id="postcode"
                class="block mt-1 w-full"
                type="text"
                name="postcode"
                value="{{ old('postcode', $company->location->postcode ?? '') }}"
                placeholder="{{ __('location.postcode.placeholder') }}"
                required
                autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('postcode')" class="mt-1 location-error" />
        </div>


        <div class="w-full px-4 mb-8">
            <x-input-label for="province" :value="__('location.province.label')" />
            <input type="hidden" class="old_province" value="{{ old('province') }}">
            <x-select name="province" id="province">
                <option value="default">{{ __('location.province.placeholder') }}</option>
                <option value="Dolnośląskie">Dolnośląskie</option>
                <option value="Kujawsko-pomorskie">Kujawsko-pomorskie</option>
                <option value="Lubelskie"> Lubelskie </option>
                <option value="Lubuskie"> Lubuskie </option>
                <option value="Łódzkie"> Łódzkie </option>
                <option value="Małopolskie"> Małopolskie </option>
                <option value="Mazowieckie"> Mazowieckie </option>
                <option value="Opolskie"> Opolskie </option>
                <option value="Podkarpackie"> Podkarpackie </option>
                <option value="Podlaskie"> Podlaskie </option>
                <option value="Pomorskie"> Pomorskie </option>
                <option value="Śląskie"> Śląskie </option>
                <option value="Świętokrzyskie"> Świętokrzyskie </option>
                <option value="Warmińsko-mazurskie"> Warmińsko-mazurskie </option>
                <option value="Wielkopolskie"> Wielkopolskie </option>
                <option value="Zachodniopomorskie"> Zachodniopomorskie </option>
            </x-select>
            <x-input-error :messages="$errors->get('province')" class="mt-1 location-error" />
        </div>

        <div class="w-full px-4 mb-8">
            <x-input-label for="city" :value="__('location.city.label')" />
            <x-text-input
                id="city"
                class="block mt-1 w-full"
                type="text"
                name="city"
                value="{{ old('city', $company->location->city ?? '') }}"
                placeholder="{{ __('location.city.placeholder') }}"
                autofocus
                required
                autocomplete="off"
            />
            <x-input-error :messages="$errors->get('city')" class="mt-1 location-error" />
        </div>

        <div class="w-full px-4 mb-8">
            <x-input-label for="street" :value="__('location.street.label')" />
            <x-text-input
                required
                id="street"
                class="block mt-1 w-full"
                type="text"
                name="street"
                value="{{ old('street') }}"
                autocomplete="off"
                placeholder="{{ __('location.street.placeholder') }}"
            />
            <x-input-error :messages="$errors->get('street')" class="mt-1 location-error" />
        </div>

        <div class="w-full px-4 mb-8">

            <x-input-label for="email" :value="__('location.email.label')" />
            <x-text-input
                required
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                value="{{ old('email', $company->adress->email ?? '') }}"
                autocomplete="off"
                placeholder="{{ __('location.email.placeholder') }}"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1 location-error" />
        </div>

        <div class="w-full px-4 mb-8">

            <x-input-label for="phone" :value="__('location.phone.label')" />
            <x-text-input
                required
                id="phone"
                class="block mt-1 w-full"
                type="tel"
                name="phone"
                placeholder="{{ __('location.phone.placeholder') }}"
                value="{{ old('phone', $company->location->name ?? '') }}"
                autocomplete="off"
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-1 location-error" />
        </div>

    </div>

</div>

@vite('resources/js/location.js')
@vite('resources/css/location.css')
