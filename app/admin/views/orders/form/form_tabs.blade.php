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
            class="tab-pane {{ (('#'.$tabs->section.'tab-'.$loop->iteration) == $activeTab) ? 'active' : '' }}"
            id="{{ $tabs->section.'tab-'.$loop->iteration }}">
            <div class="form-fields">
                @if ($loop->iteration == 1)
                    <div class="row w-100">
                        <div class="col-md-9">
                            @isset($fields['order_menus'])
                                <div class="card bg-light shadow-sm mb-2 p-2">
                                    {!! $this->renderFieldElement($fields['order_menus']) !!}
                                </div>
                            @endisset
                            @isset($fields['order_details'])
                                <div class="card bg-light shadow-sm mb-2 p-2">
                                    {!! $this->renderFieldElement($fields['order_details']) !!}
                                </div>
                            @endisset
                        </div>
                        <div class="col-md-3 px-md-0">
                            @if($formModel->comment)
                                <div class="card bg-light shadow-sm mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">@lang('admin::lang.orders.label_comment')</h5>
                                        <p class="mb-0">{{ $formModel->comment }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="card bg-light shadow-sm mb-2">
                                @isset($fields['customer'])
                                    {!! $this->renderFieldElement($fields['customer']) !!}
                                @endisset
                            </div>
                            @isset($fields['location'])
                                <div class="card bg-light shadow-sm mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">@lang($fields['location']->label)</h5>
                                        {!! $this->renderFieldElement($fields['location']) !!}
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                @else
                    {!! $this->makePartial('form/form_fields', ['fields' => $fields]) !!}
                @endif
            </div>
        </div>
    @endforeach
</div>
