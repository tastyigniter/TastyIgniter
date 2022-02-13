{!! form_open([
    'id' => 'list-form',
    'role' => 'form',
    'method' => 'POST',
]) !!}

<div
    id="{{ $this->getId() }}"
    class="list-table table-responsive"
>
    <table
        id="{{ $this->getId('table') }}"
        class="table table-hover mb-0 border-bottom"
    >
        <thead>
        @if ($showCheckboxes)
            {!! $this->makePartial('lists/list_actions') !!}
        @endif
        {!! $this->makePartial('lists/list_head') !!}
        </thead>
        <tbody>
        @if(count($records))
            {!! $this->makePartial('lists/list_body') !!}
        @else
            <tr>
                <td colspan="99" class="text-center">{{ $emptyMessage }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

{!! form_close() !!}

{!! $this->makePartial('lists/list_pagination') !!}

@if ($showSetup)
    {!! $this->makePartial('lists/list_setup') !!}
@endif
