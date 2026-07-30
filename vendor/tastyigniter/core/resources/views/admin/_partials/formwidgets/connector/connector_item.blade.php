<div
    id="{{ $this->getId('item-'.$index) }}"
    class="card shadow-sm card-hover mb-3"
    data-item-index="{{ $index }}"
>
    <div class="card-body">
        <div class="d-flex w-100 align-items-center justify-content-between">
            @if(!$this->previewMode && $sortable)
                <input type="hidden" name="{{ $sortableInputName }}[]" value="{{ $item->getKey() }}">
                <div class="align-self-center">
                    <a
                        class="btn handle shadow-none mr-2 {{ $this->getId('items') }}-handle"
                        role="button">
                        <i class="fa fa-arrows-alt-v text-black-50"></i>
                    </a>
                </div>
            @endif
            <div
                class="flex-fill"
                data-control="load-item"
                data-item-id="{{ $item->getKey() }}"
                role="button"
            >
                @if($this->partial)
                    {!! $this->makePartial($this->partial, ['item' => $item]) !!}
                @else
                    <p class="card-title font-weight-bold">{{ $item->{$nameFrom} }}</p>
                    <p class="card-subtitle mb-0">{!! $item->{$descriptionFrom} !!}</p>
                @endif
            </div>
            @unless ($this->previewMode || !$this->editable)
                <div class="align-self-center ml-auto">
                    <a
                        class="btn btn-link text-danger"
                        aria-label="Remove"
                        data-control="delete-item"
                        data-request="{{$this->getEventHandler('onDeleteRecord')}}"
                        data-request-data="'recordId': '{{ $item->getKey() }}'"
                        data-request-confirm="@lang($confirmMessage)"
                    ><i class="fa fa-trash-alt"></i></a>
                </div>
            @endunless
        </div>
    </div>
</div>
