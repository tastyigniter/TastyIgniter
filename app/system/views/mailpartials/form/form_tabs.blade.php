@php
    $type = $tabs->section;
    $activeTab = $activeTab ? $activeTab : '#'.$type.'tab-1';
@endphp
<div class="tab-heading">
    <ul class="form-nav nav nav-tabs">
        @foreach ($tabs as $name => $fields)
            @php
                $tabName = '#'.$type.'tab-'.$loop->iteration;
            @endphp
            <li class="nav-item">
                <a
                    class="nav-link{{ ($tabName == $activeTab) ? ' active' : '' }}"
                    href="{{ $tabName }}"
                    data-bs-toggle="tab"
                >@lang($name)</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="row no-gutters">
    <div class="col-md-8">
        <div class="tab-content">
            @foreach ($tabs as $name => $fields)
                @php
                    $tabName = '#'.$type.'tab-'.$loop->iteration;
                @endphp
                <div
                    class="tab-pane {{ ($tabName == $activeTab) ? 'active' : '' }}"
                    id="{{ $type.'tab-'.$loop->iteration }}">
                    <div class="form-fields">
                        {!! $this->makePartial('form/form_fields', ['fields' => $fields]) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4 pl-md-3">
        {!! $this->makePartial('mailtemplates/form/variables', [
            'cssClass' => ' form-fields pl-0',
            'variables' => \System\Classes\MailManager::instance()->listRegisteredVariables(),
        ]) !!}
    </div>
</div>
