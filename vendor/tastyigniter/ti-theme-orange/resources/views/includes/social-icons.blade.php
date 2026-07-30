<ul class="social-icons list-inline">
    @foreach ($theme->social ?? [] as $icon)
        <li>
            <a
                class="p-2 {{ array_get($icon, 'class') }}"
                target="_blank"
                title="{{ array_get($icon, 'title') }}"
                href="{{ array_get($icon, 'url') }}">
            </a>
        </li>
    @endforeach
</ul>
