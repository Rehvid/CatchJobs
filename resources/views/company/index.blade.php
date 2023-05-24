<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="company-grid">
                @foreach ($companies as $company)
                    <a href="{{route('companies.show', $company->slug)}}"
                       class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-6 px-6 py-6 border">
                            <div class="flex flex-col items-center pb-10">
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
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white py-2">{{ $company->name }}</h5>
                                @if($company->location)
                                    <div class="flex items-center py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 pl-1">{{ $company->location->province }},</span>
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400 px-1">{{ $company->location->city }}</span>
                                    </div>
                                @endif
                                @if($company->industry)
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                                        </svg>
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400 pl-1">{{ $company->industry->name }}</span>
                                    </div>
                                @endif
                            </div>
                    </a>
                @endforeach
            </div>
            <div class="px-6 mx-6">
                {{ $companies->links() }}
            </div>
        </div>

    </div>

    @vite('resources/css/company.css')
</x-app-layout>
