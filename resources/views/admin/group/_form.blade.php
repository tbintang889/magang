<form method="POST" action="{{ $action }}" class="space-y-6 bg-white p-6 rounded-md shadow-sm">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <x-form.input name="name" :value="$group->name ?? ''" required />

    <x-form.input name="start_date" type="date" :value="$group->start_date ?? ''" />
    <x-form.input name="end_date" type="date" :value="$group->end_date ?? ''" />
<x-form.select
    name="school_id"
    :options="$schools"
    optionValue="id"
    optionLabel="name"
    :selected="$group->school_id ?? ''"
    required
/>
    <div class="pt-4">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-black  rounded-md font-semibold text-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $submitLabel }}
        </button>
    </div>
</form>