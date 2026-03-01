@props([
    'type' => 'submit',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'disabled' => false,
    'icon' => null,
])

@php
    $baseClasses = 'btn';
    
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        'danger' => 'btn-danger',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
    ];
    
    $sizes = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
    ];
    
    $classes = trim($baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? ''));
    
    if ($disabled) {
        $classes .= ' disabled';
    }
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" {{ $attributes->class(['disabled' => $disabled]) }}>
        @if($icon)<span class="btn-icon">{{ $icon }}</span>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->class(['loading' => $attributes->has('loading')]) }}>
        @if($icon)<span class="btn-icon">{!! $icon !!}</span>@endif
        {{ $slot }}
    </button>
@endif
