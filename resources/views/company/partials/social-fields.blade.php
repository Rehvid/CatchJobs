<div class="w-full px-4 mb-8">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('company.social_title') }}
    </h2>
</div>

@foreach($socialNetworks as $socialNetworkId => $socialNetwork)
    <div class="w-full px-4 mb-8">
        <x-input-label for="{{ $socialNetwork }}" :value="__('company.' . $socialNetwork . '.label')" optional="true" />
        <x-text-input
            id="{{$socialNetwork}}"
            class="block mt-1 w-full"
            type="text"
            name="{{$socialNetwork}}"
            value="{{ old($socialNetwork, isset($company) === true ? $company->socialByNetworkId($socialNetworkId)?->url : '')}}"
            autofocus
            autocomplete="name"
        />
        <x-input-error :messages="$errors->get($socialNetwork)" class="mt-1 " />
    </div>
@endforeach

