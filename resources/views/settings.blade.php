<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">{{ __('Seat layout') }}</h3>
                    <form method="POST" action="{{ route('settings.seat-layout.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="class_size" class="block text-sm font-medium text-gray-700">{{ __('Class size') }}</label>
                            <input type="number" name="class_size" id="class_size" min="0" max="65535" value="{{ old('class_size', $seatLayout?->class_size ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="{{ __('Number of classmates') }}">
                        </div>
                        <div>
                            <label for="rows" class="block text-sm font-medium text-gray-700">{{ __('Rows') }}</label>
                            <input type="number" name="rows" id="rows" min="1" max="255" value="{{ old('rows', $seatLayout?->rows ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="cols" class="block text-sm font-medium text-gray-700">{{ __('Cols') }}</label>
                            <input type="number" name="cols" id="cols" min="1" max="255" value="{{ old('cols', $seatLayout?->cols ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
