<div class="d-flex align-items-center">
    <div class="px-2">
        <i
            class="fa fa-asterisk {{ $item->isRequired() ? 'text-danger' : 'text-muted' }}"
            title="{{ $item->isRequired()
                ? lang('igniter.cart::default.menu_options.is_required')
                : lang('igniter.cart::default.menu_options.is_not_required') }}"
        ></i>
    </div>
    <div class="px-2">
        @if($item->display_type == 'radio')
            <i
                title="{{ sprintf(lang('igniter.cart::default.menu_options.text_option_summary'), $item->display_type) }}"
                class="fa fa-dot-circle text-muted"
            ></i>
        @elseif($item->display_type == 'checkbox')
            <i
                title="{{ sprintf(lang('igniter.cart::default.menu_options.text_option_summary'), $item->display_type) }}"
                class="fa fa-check-square text-muted"
            ></i>
        @elseif($item->display_type == 'select')
            <i
                title="{{ sprintf(lang('igniter.cart::default.menu_options.text_option_summary'), $item->display_type) }}"
                class="fa fa-caret-square-down text-muted"
            ></i>
        @elseif($item->display_type == 'quantity')
            <i
                title="{{ sprintf(lang('igniter.cart::default.menu_options.text_option_summary'), $item->display_type) }}"
                class="fa fa-hashtag text-muted"
            ></i>
        @else
            {{ sprintf(lang('igniter.cart::default.menu_options.text_option_summary'), $item->display_type) }}
        @endif
    </div>
    <div class="px-2">
        <p class="card-title font-weight-bold mb-1">{{ $item->option_name }}</p>
        @foreach($item->menu_option_values->sortBy('priority')->take(10) as $menuItemOptionValue)
            <span class="badge border">{{ $menuItemOptionValue->name }}</span>
        @endforeach
    </div>
</div>
