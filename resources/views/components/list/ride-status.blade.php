@props([
    'ride',
])

@php
    $status = RideStatusEnum::tryFrom($ride->ride_status_id);
    $classes = match($status) {
        RideStatusEnum::DRAFT       => 'bg-gray-100 text-gray-600',
        RideStatusEnum::RECRUITING  => 'bg-blue-100 text-blue-600',
        RideStatusEnum::CLOSED      => 'bg-green-100 text-green-700',
        RideStatusEnum::CANCELLED   => 'bg-red-100 text-red-600',
        default                     => 'bg-gray-100 text-gray-500',
    };
@endphp

<span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-full {{ $classes }}">
    {{ $status?->label() ?? '不明' }}
</span>