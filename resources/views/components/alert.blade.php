@props([
    'type' => 'info',
    'dismissible' => false,
])

@php
    $types = [
        'success' => 'alert-success',
        'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];
    
    $classes = 'alert ' . ($types[$type] ?? $types['info']);
    if ($dismissible) {
        $classes .= ' alert-dismissible';
    }
@endphp

<div class="{{ $classes }}" role="alert">
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
    {{ $slot }}
</div>
