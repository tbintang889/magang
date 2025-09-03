@props([
    'name',
    'label' => ucfirst($name),
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'selected' => '',
    'required' => false,
])

<div class="space-y-1">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge([
            'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm'
        ]) }}
    >
        <option value="">-- Pilih {{ strtolower($label) }} --</option>

        @foreach ($options as $option)
            <option value="{{ $option[$optionValue] ?? $option->$optionValue }}"
                @selected(old($name, $selected) == ($option[$optionValue] ?? $option->$optionValue))>
                {{ $option[$optionLabel] ?? $option->$optionLabel }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>