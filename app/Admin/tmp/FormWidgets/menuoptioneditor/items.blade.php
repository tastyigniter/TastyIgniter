@forelse ($fieldItems as $fieldItem)
    <div
        id="{{ $this->getId('item-'.$loop->iteration) }}"
        class="card bg-light shadow-sm mb-2"
        data-item-index="{{ $loop->iteration }}"
    >
        <div class="card-body">
            <div class="d-flex w-100 justify-content-between">
                <div
                    class="flex-fill"
                    data-control="load-item"
                    data-item-id="{{ $fieldItem->getKey() }}"
                    role="button"
                >
                    {!! $this->makePartial('menuoptioneditor/item', ['item' => $fieldItem]) !!}
                </div>
                @unless ($this->previewMode)
                    <div class="align-self-center ml-auto">
                        <a
                            class="close text-danger"
                            aria-label="Remove"
                            data-control="delete-item"
                            data-item-id="{{ $fieldItem->getKey() }}"
                            data-item-selector="#{{ $this->getId('item-'.$loop->iteration) }}"
                            data-confirm-message="@lang($confirmMessage)"
                        ><i class="fa fa-trash-alt"></i></a>
                    </div>
                @endunless
            </div>
        </div>
    </div>
@empty
    @lang($emptyMessage)
@endforelse
