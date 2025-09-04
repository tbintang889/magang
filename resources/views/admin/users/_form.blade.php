
<form method="POST" action="{{ $action }}" class="space-y-6 bg-white p-6 rounded-md shadow-sm">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <x-form.input name="name" :value="$user->name ?? ''" required />

    <x-form.input name="email" type="email" :value="$user->email ?? ''" />
    <x-form.input name="password" type="password" :value="''" :required="!isset($user)" />
    <x-form.input name="password_confirmation" type="password" :value="''" :required="!isset($user)" />

    <x-form.select
    name="role_id"
    :options="$roles"
    optionValue="name"
    optionLabel="name"
    :selected="$user->getRoleNames()->toArray()[0] ?? ''"
    required
/>
    <div class="pt-4">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-black  rounded-md font-semibold text-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $submitLabel }}
        </button>
    </div>
</form>