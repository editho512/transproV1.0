<span class="text-warning">
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        *
    @endif
</span>
