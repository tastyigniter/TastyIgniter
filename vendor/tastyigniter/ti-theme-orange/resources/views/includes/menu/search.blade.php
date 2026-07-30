<x-igniter-orange::forms.form
    id="menu-search"
    wire:submit="$refresh"
>
    <div class="input-group bg-white border border-2 rounded">
        <div
            class="bg-white d-inline-flex align-items-center py-1 px-2 rounded"
        ><i class="fa fa-search"></i></div>
        <input
            wire:model.live.debounce="menuSearchTerm"
            type="search"
            class="bg-white form-control py-2 border-0 shadow-none rounded"
            placeholder="@lang('igniter.local::default.label_menu_search')"
            autocomplete="off"
        >
        @if (strlen($menuSearchTerm))
            <a
                wire:click="$set('menuSearchTerm', '')"
                class="btn bg-white p-2"
            ><i class="fa fa-times"></i></a>
        @endif
    </div>
</x-igniter-orange::forms.form>
