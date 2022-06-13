<span class="text-danger">
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        *
    @endif
</span>
