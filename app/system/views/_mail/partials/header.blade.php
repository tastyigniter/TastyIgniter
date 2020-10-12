name = "Header"
==
*** {{ $slot }} <{{ $url }}>
==
<tr>
    <td class="header">
        @if (isset($url))
        <a href="{{ $url }}">
            {{ $slot }}
        </a>
        @else
        <span>
            {{ $slot }}
        </span>
        @endif
    </td>
</tr>
