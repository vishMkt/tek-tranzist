
@props([
    'options' => [],
    'selectedOptions' => []
])

<select {{ $attributes->merge(['class' => 'form-control']) }}>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ $isSelected($value,$selectedOptions) ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>