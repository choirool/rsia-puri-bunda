<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Units') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <unit-index />
        </div>
    </div>

    @push('scripts')
    @vite(['resources/js/units.js'])
    @endpush
</x-app-layout>