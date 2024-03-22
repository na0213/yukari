<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者画面{{ __('Dashboard') }}
        </h2>
    </x-slot>

    <a href="{{ route('admin.backend.regions.index') }}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        【地域管理】
                    </div>
                </div>
            </div>
        </div>
    </a>
    {{-- <a href="{{ route('admin.backend.owners.index') }}"> --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        【称号管理】
                    </div>
                </div>
            </div>
        </div>
    {{-- </a> --}}
    {{-- <a href="{{ route('admin.backend.owners.index') }}"> --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        【ユーザー管理】
                    </div>
                </div>
            </div>
        </div>
    {{-- </a> --}}
</x-admin-layout>
