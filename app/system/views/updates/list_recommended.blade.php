<div
    class="modal-dialog modal-lg modal-dialog-scrollable"
    role="document"
>
    {!! form_open([
        'id' => 'list-recommended-form',
        'role' => 'form',
        'method' => 'PATCH',
    ]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ sprintf(lang('system::lang.updates.text_popular_title'), ucwords(str_plural($itemType))) }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            @if (isset($items) && count($items))
                @foreach ($items['data'] as $index => $item)
                    <div class="card card-body {{ empty($item['installed']) ? 'bg-white' : '' }} mb-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <span
                                    class="extension-icon rounded pull-left"
                                    style="{{ $item['icon']['styles'] ?? '' }}"
                                ><i class="{{ $item['icon']['class'] ?? 'fa fa-paint-brush' }}"></i></span>
                            </div>
                            <div class="flex-grow-1 px-3">
                                <b>{{ $item['name'] }}</b><span class="small text-muted"> by {{ $item['author'] }}</span>
                                <p class="help-block font-weight-normal">{{ str_limit($item['description'], 128) }}</p>
                            </div>
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    id="list-recommended-{{ $item['code'] }}"
                                    class="form-check-input"
                                    name="install_items[{{ $index }}]"
                                    value="{{ $item['code'] }}"
                                    {{ ($itemType != 'theme' || $loop->first) ? 'checked="checked"' : '' }}
                                    {!! empty($item['installed']) ? '' : 'disabled="disabled"' !!}
                                />
                                <label
                                    class="form-check-label"
                                    for="list-recommended-{{ $item['code'] }}"
                                ></label>
                            </div>
                        </div>
                        <input type="hidden" name="items[{{ $index }}][name]" value="{{ $item['code'] }}">
                        <input type="hidden" name="items[{{ $index }}][type]" value="{{ $item['type'] }}">
                        <input type="hidden" name="items[{{ $index }}][ver]" value="{{ $item['version'] }}">
                        <input type="hidden" name="items[{{ $index }}][action]" value="install">
                    </div>
                @endforeach
            @endif
        </div>
        <div class="modal-footer">
            <button
                type="button"
                class="btn btn-primary"
                data-control="apply-recommended"
            >@lang('system::lang.updates.button_install')</button>
        </div>
    </div>
    {!! form_close() !!}
</div>
