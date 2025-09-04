
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
                   
<form action="{{ route($action, $group) }}" method="POST" enctype="multipart/form-data"  class="space-y-6 bg-white p-6 rounded-md shadow-sm">
    @csrf
   
<!-- Select2 Multi Select -->
<select name="member_ids[]" multiple="multiple" class="select2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
    @foreach($members as $member)
        <option value="{{ $member->id }}"
            {{ in_array($member->id, old('member_ids', $selectedMemberIds ?? [])) ? 'selected' : '' }}>
            {{ $member->name }}
        </option>
    @endforeach
</select>



    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-black  rounded-md font-semibold text-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Simpan</button>
</form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>