

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>{{ $school->name }}</h2>
                    <p><strong>Address:</strong> {{ $school->address }}</p>
                    <p><strong>Email:</strong> {{ $school->email }}</p>
                    <a href="{{ route('schools.edit', $school) }}">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
