@php
    $activeTab = $activeTab ? $activeTab : '#'.$tabs->section.'tab-1';
@endphp
<div class="tab-heading">
    <ul class="form-nav nav nav-tabs">
        @foreach ($tabs as $name => $fields)
            <li class="nav-item">
                <a
                    class="nav-link{{ (('#'.$tabs->section.'tab-'.$loop->iteration) == $activeTab) ? ' active' : '' }}"
                    href="{{ '#'.$tabs->section.'tab-'.$loop->iteration }}"
                    data-bs-toggle="tab"
                >@lang($name)</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="tab-content">
    @foreach ($tabs as $name => $fields)
        <div
            class="tab-pane p-3 {{ (('#'.$tabs->section.'tab-'.$loop->iteration) == $activeTab) ? 'active' : '' }}"
            id="{{ $tabs->section.'tab-'.$loop->iteration }}">
            <div class="form-fields py-3">
                @if ($name === 'igniter.reservation::default.dining_areas.text_tab_tables')
                    <div class="row w-100">
                        <div class="col-md-4">
                            <h5 class="mb-3">@lang($fields['_dining_sections']->label)</h5>
                            {!! $this->renderFieldElement($fields['_dining_sections']) !!}
                        </div>
                        @isset($fields['dining_table_solos'])
                            <div class="col-md-8">
                                {!! $this->renderFieldElement($fields['dining_table_solos']) !!}
                            </div>
                        @endisset
                    </div>
                @else
                    {!! $this->makePartial('form/form_fields', ['fields' => $fields]) !!}
                @endif
            </div>
        </div>
    @endforeach
</div>
