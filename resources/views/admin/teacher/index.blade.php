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

                    <a href="{{ route('teachers.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                        {{ __('Tambah Guru') }}
                    </a>
                      <a href="{{ route('teachers.export') }}">Export</a>

                </div>
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Code</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Email</th>
                                  
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($teachers as $teacher)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $teacher->teacher_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $teacher->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $teacher->email }}</td>
                                       
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center gap-2">
                                                <x-action-buttons :view="route('teachers.show', $teacher)" :edit="route('teachers.edit', $teacher)" :delete="route('teachers.destroy', $teacher)" />
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada
                                            data sekolah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $teachers->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
