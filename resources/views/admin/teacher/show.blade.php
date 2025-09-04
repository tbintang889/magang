

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>{{ $teacher->name }}</h2>
                    <p><strong>Address:</strong> {{ $teacher->address }}</p>
                    <p><strong>Email:</strong> {{ $teacher->email }}</p>
                    <a href="{{ route('teachers.edit', $teacher) }}">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
