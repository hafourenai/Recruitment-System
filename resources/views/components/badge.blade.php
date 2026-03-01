@props([
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $variants = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'success' => 'badge-success',
        'danger' => 'badge-danger',
        'warning' => 'badge-warning',
        'info' => 'badge-info',
        'pending' => 'badge-pending',
    ];
    
    $sizes = [
        'sm' => 'badge-sm',
        'md' => '',
        'lg' => 'badge-lg',
    ];
    
    $classes = 'badge ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? '');
@endphp

<span class="{{ $classes }}">
    {{ $slot }}
</span>
