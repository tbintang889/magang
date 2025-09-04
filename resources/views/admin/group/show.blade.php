<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                {{-- Info Group --}}
                <div class="mb-6">
                    <h2 class="text-xl font-bold">{{ $group->name }}</h2>
                    <p><strong>Tanggal:</strong> {{ $group->start_date }}</p>
                    <p><strong>Sampai:</strong> {{ $group->end_date }}</p>
                    <p><strong>Sekolah:</strong> {{ $school->name }}</p>
                    <a href="{{ route('groups.edit', $group) }}" class="text-blue-500">Edit</a>
                </div>

                {{-- Grid 2 Kolom --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kolom 1: Anggota Group --}}
                    <div>
                        <h3 class="font-semibold">Anggota Group</h3>
                        <a href="{{ route('groups.formStudents', $group) }}" class="text-blue-500">Tambah Anggota</a>
                        <div class="mt-4">
                            <ol class="list-decimal list-inside">
                                @foreach ($group->students as $student)
                                    <li>{{ $student->name }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    {{-- Kolom 2: Pengajar Group --}}
                    <div>
                        <h3 class="font-semibold">Pengajar Group</h3>
                        <a href="{{ route('groups.formTeachers', $group) }}" class="text-blue-500">Tambah Anggota</a>
                        <div class="mt-4">
                            <ul class="list-disc list-inside">
                                @foreach ($group->teachers as $teacher)
                                    <li>{{ $teacher->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold">Dokumen Group</h3>

                        <form action="{{ route('groups.storeDocument', $group) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="file_name" class="block text-sm font-medium text-gray-700">Judul
                                    Dokumen</label>
                                <input type="text" name="file_name" id="title"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="file" class="block text-sm font-medium text-gray-700">File
                                    Dokumen</label>

                                <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,image/*"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                    required>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-blue-500 rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">Tambah
                                Dokumen</button>
                        </form>
                        <div class="mt-4">
                            <ul class="list-disc list-inside">
                                @foreach ($group->documents as $document)
                                    <li> <a href="{{ Storage::url($document->file_path) }}" target="_blank">
                                            {{ $document->file_name }}</a>
                                        <form
                                            action="{{ route('groups.destroyDocument', ['group' => $group->id, 'id' => $document->id]) }}"
                                            method="POST" onsubmit="return confirm('Yakin mau hapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
