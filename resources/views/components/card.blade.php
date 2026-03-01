@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
])

<div class="card{{ !$padding ? ' card-no-padding' : '' }}">
    @if($title || $subtitle)
        <div class="card-header">
            @if($title)
                <h3 class="card-title">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="card-subtitle">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
