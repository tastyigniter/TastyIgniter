@forelse ($fieldItems as $fieldItem)
    {!! $this->makePartial('connector/connector_item', [
        'item' => $fieldItem,
        'index' => $loop->iteration,
    ]) !!}
@empty
    @lang($emptyMessage)
@endforelse
