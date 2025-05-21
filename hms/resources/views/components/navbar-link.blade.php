@props(['href', 'icon', 'isActive'])

@php
    $isActive = $isActive ?? false; // Default to false if not provided
@endphp

<li class="nav-item">
    <a href="{{ $href }}" @class([
        'nav-link',
        'active' => $isActive,
        'hover' => ! $isActive,
    ]) aria-current="page">
        @if ($icon)
            <i class="{{ $icon }}"></i> <!-- Assuming the icon class is provided -->
        @endif
        {{ $slot }}
    </a>
</li>
