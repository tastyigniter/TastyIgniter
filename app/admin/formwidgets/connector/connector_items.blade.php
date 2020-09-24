@foreach ($fieldItems as $fieldItem)
    {!! $this->makePartial('connector/connector_item', [
        'item' => $fieldItem,
        'index' => $loop->iteration,
    ]) !!}
@endforeach
