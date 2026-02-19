@props([
    'icon',
    'label',
    'value',
])

<div class="py-1.5 flex flex-row">
    <p><i class="las {{ $icon }} la-lg"></i></p>
    <p class="pl-2 w-36">{{ $label }}</p>
    <p>{{ $value }}</p>
</div>