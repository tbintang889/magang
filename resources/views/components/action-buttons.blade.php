<div class="flex items-center gap-x-4 px-2 py-1">
    <a href="{{ $view }}" class="text-blue-600 hover:underline">View</a> | 
    <a href="{{ $edit }}" class="text-green-600 hover:underline">Edit</a> | 
    <form action="{{ $delete }}" method="POST" class="inline">
        @csrf @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
    </form>
</div>