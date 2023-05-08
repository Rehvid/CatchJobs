<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('company.list_title') }}
            </h2>
            <x-primary-button> <a href="{{ route('companies.create') }}">{{__('company.create')}}</a></x-primary-button>
        </div>
    </x-slot>

    @if(session()->has('success'))
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
                                    {{ __('company.name.label')  }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('company.status')  }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('company.industry.label')  }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('global.actions')  }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($companies as $key => $company)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="flex items-center px-2 py-4">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-slate-100 ">
                                            <svg class="w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                            </svg>
                                        </div>
                                        <div  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $company->name }}
                                        </div>

                                    </th>
                                    <td class="px-6 py-4">
                                        <x-status-badge status="{{ $company->status }}"/>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $company->industry?->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex">
                                            <a  data-tooltip-target="tooltip-show" type="button" class="w-6 block mr-2"
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
                                            <a  data-tooltip-target="tooltip-edit" type="button" class="w-6 block mr-2"
                                                href="{{ route('companies.edit', $company->slug) }}">
                                                <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                     aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a  data-tooltip-target="tooltip-remove" type="button" class="w-6 block mr-2"
                                                href="{{ route('companies.destroy', $company->slug) }}">
                                                <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                     aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <div id="tooltip-show" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.show') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.edit') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <div id="tooltip-remove" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ __('company.remove') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            </tbody>
                        </table>
                    </div>
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
