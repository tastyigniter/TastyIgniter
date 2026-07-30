<div class="autocomplete-suggestions list-group mt-2 border-top rounded-bottom-0">
    @forelse($placesSuggestions as $key => $suggestion)
        <button
            type="button"
            class="list-group-item list-group-item-action"
            wire:click="onSelectSuggestion({{ $key }})"
        >
            @if($suggestion['title'])
                <div class="fw-bold">{{ $suggestion['title'] }}</div>
            @endif
            @if($suggestion['description'])
                <div>{{ $suggestion['description'] }}</div>
            @endif
        </button>
    @empty
        <div class="list-group-item text-center">
            No suggestions found
        </div>
    @endforelse
</div>
<div class="p-1 text-end border rounded rounded-top-0">
    <small>
        @if($geocoder === 'nominatim')
            Powered by
            <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>
        @else
            <a href="https://maps.google.com" target="_blank" rel="noopener">
                <img src="{{ asset('vendor/igniter-orange/images/powered-by-google.png') }}" style="height:12px"
                    alt="Powered by Google"/>
            </a>
        @endif
    </small>
</div>
