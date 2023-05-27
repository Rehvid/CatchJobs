<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('company.list_title') }}
            </h2>
            <x-primary-button><a href="{{ route('admin.companies.create') }}">{{ __('company.create') }}</a>
            </x-primary-button>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <x-toast-notification type="success" :message="session()->get('success')" />
    @endif


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mt-6 flex flex-wrap mb-6 p-4 sm:p-4 bg-white shadow sm:rounded-lg">
                <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 w-full">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="bg-slate-100 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('company.name.label') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('company.status') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('company.industry.label') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('global.actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($companies as $key => $company)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="flex items-center px-2 py-4">

                                        @if ($company->fileByCollection('logo'))
                                            <img class="rounded-full w-16 h-16"
                                                 src="{{ $company->fileByCollection('logo')->getPublicPath() }}"
                                                 alt="logo" />
                                        @else
                                            <div
                                                class="w-16 h-16 rounded-full flex items-center justify-center bg-slate-100 ">
                                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                                     stroke="currentColor" className="w-6 h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                          d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                          d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $company->name }}
                                        </div>

                                    </th>
                                    <td class="px-6 py-4">

                                        @if ($company->status === \App\Enums\Status::REJECT)
                                            <div class="flex">
                                                <x-status-badge status="{{ $company->status }}" />
                                                <span class="w-5 block " data-tooltip-target="tooltip-status{{ $company->id }}">
                                                        <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                             aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                <div id="tooltip-status{{ $company->id }}" role="tooltip"
                                                     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                    {!! clean($company->status_message) !!}
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            </div>
                                        @else
                                            <x-status-badge status="{{ $company->status }}" />
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $company->industry?->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex">
                                            <a data-tooltip-target="tooltip-show" type="button"
                                               class="w-6 block mr-2"
                                               href="{{ route('companies.show', $company->slug) }}">
                                                <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                     aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </a>
                                            <a data-tooltip-target="tooltip-edit" type="button"
                                               class="w-6 block mr-2"
                                               href="{{ route('admin.companies.edit', $company->slug) }}">
                                                <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                     aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button data-tooltip-target="tooltip-update-status"
                                                    data-modal-target="status-modal" data-modal-toggle="status-modal"
                                                    data-url="{{ route('admin.companies.update_status', $company->slug) }}"
                                                    data-status-message="{{ $company->status_message }}"
                                                    data-status-id="{{ $company->status }}"
                                                    class="w-6 block mr-2 js-status-modal">
                                                <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                     aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <form method='POST'
                                                  action="{{ route('companies.destroy', $company->slug) }}">
                                                @csrf
                                                @method('delete')
                                                <button data-tooltip-target="tooltip-remove"
                                                        class="w-6 block mr-2">
                                                    <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                         aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <div id="tooltip-show" role="tooltip"
                                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.show') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <div id="tooltip-edit" role="tooltip"
                                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.edit') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <div id="tooltip-update-status" role="tooltip"
                                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.status_change') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <div id="tooltip-remove" role="tooltip"
                                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.remove') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            </tbody>
                        </table>

                        <div id="status-modal" tabindex="-1" aria-hidden="true"
                             class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button"
                                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                            data-modal-hide="status-modal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="px-6 py-6 lg:px-8">
                                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                            {{ __('company.status_title') }}</h3>
                                        <form method="POST" id="company-status" class="space-y-6" action="">
                                            @csrf
                                            @method('patch')
                                            <div>
                                                <x-input-label for="status" :value="__('company.status')" />
                                                <x-select name="status" id="status">
                                                    @foreach (\App\Enums\Status::cases() as $status)
                                                        <option value="{{ $status->value }}">
                                                            {{ __('global.status.' . Str::lower($status->name)) }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                                <x-input-error :messages="$errors->get('status')" class="mt-1" />
                                            </div>
                                            <div>
                                                <x-input-label for="status_message" :value="__('company.status_message')" optional="true" />
                                                <textarea class="js-status-message" id="status_message" name="status_message"></textarea>
                                                <x-input-error :messages="$errors->get('status_message')" class="mt-1" />
                                            </div>
                                            <button type="submit"
                                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                {{ __('company.status_update') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{ $companies->links() }}
                </div>
            </div>
        </div>

    </div>
    @vite('resources/js/company.js')
</x-app-layout>
