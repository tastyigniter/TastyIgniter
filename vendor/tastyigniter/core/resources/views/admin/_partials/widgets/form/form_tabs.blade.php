<div class="tab-heading">
    <ul class="form-nav nav nav-tabs">
        @foreach($tabs as $name => $fields)
            <li class="nav-item">
                <a
                    @class([
                        'nav-link',
                        'active' => (('#'.$tabs->section.'tab-'.$loop->iteration) == $activeTab)
                    ])
                    href="{{ '#'.$tabs->section.'tab-'.$loop->iteration }}"
                    data-bs-toggle="tab"
                >@lang($name)</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="tab-content">
    @foreach($tabs as $name => $fields)
        <div
            @class([
                'tab-pane p-3',
                'active' => (('#'.$tabs->section.'tab-'.$loop->iteration) == $activeTab)
            ])
            id="{{ $tabs->section.'tab-'.$loop->iteration }}">
            <div class="form-fields">
                {!! $this->makePartial('form/form_fields', ['fields' => $fields]) !!}
            </div>
        </div>
    @endforeach
</div>
