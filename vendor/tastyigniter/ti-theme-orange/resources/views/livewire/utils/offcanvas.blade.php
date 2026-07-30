<div>
    <div
        x-data="OrangeOffcanvas()"
        x-show="show"
        x-on:close.stop="setShowPropertyTo(false)"
    >
        @forelse($components as $id => $component)
            <div
                x-ref="{{ $id }}"
                wire:key="{{ $id }}"
                id="offcanvas-{{ $id }}"
            >
                @livewire($component['name'], $component['arguments'], key($id))
            </div>
        @empty
            <div
                :class="{ 'd-block show': show }"
            >
                <div
                    class="offcanvas offcanvas-end"
                    tabindex="-1"
                    id="offcanvasRight"
                    aria-labelledby="offcanvasRightLabel"
                >
                    <div class="offcanvas-body">
                        <div class="text-center">
                            <div class="ti-loading spinner-border fa-3x fa-fw" role="status"></div>
                            <div class="fw-bold mt-2">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
