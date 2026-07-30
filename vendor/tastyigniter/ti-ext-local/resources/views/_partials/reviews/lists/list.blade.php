<div
    id="{{ $this->getId('list') }}"
>
    {!! $this->makePartial('lists/averages') !!}

    {!! form_open([
           'id' => $this->getId('list-form'),
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
            <thead id="{{ $this->getId('table-head') }}">
            @if ($showCheckboxes)
                {!! $this->makePartial('lists/list_actions') !!}
            @endif
            {!! $this->makePartial('lists/list_head') !!}
            </thead>
            <tbody id="{{ $this->getId('table-body') }}">
            {!! $this->makePartial('lists/list_body') !!}
            </tbody>
        </table>
    </div>

    {!! form_close() !!}

    {!! $this->makePartial('lists/list_pagination') !!}

    @if ($showSetup)
        {!! $this->makePartial('lists/list_setup') !!}
    @endif
</div>
