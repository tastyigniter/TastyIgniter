@if (isset($items) AND count($items))
    <div class="row select-box">
        @foreach ($items['data'] as $item)
            <div class="col col-sm-4 mb-4">
                {!! $this->makePartial('updates/browse/'.$itemType, ['item' => $item]) !!}
            </div>
        @endforeach
    </div>
@endif
