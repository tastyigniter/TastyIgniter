@php
    $type = $tabs->section;
    $activeTab = $activeTab ? $activeTab : '#'.$type.'tab-1';
@endphp
<div class="tab-heading">
    <ul class="form-nav nav nav-tabs">
        @foreach($tabs as $name => $fields)
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

<div class="row m-0">
    <div class="col-md-8 p-0">
        <div class="tab-content">
            @foreach($tabs as $name => $fields)
                @php
                    $tabName = '#'.$type.'tab-'.$loop->iteration;
                @endphp
                <div
                    class="tab-pane p-3 {{ ($tabName == $activeTab) ? 'active' : '' }}"
                    id="{{ $type.'tab-'.$loop->iteration }}">
                    <div class="form-fields">
                        {!! $this->makePartial('form/form_fields', ['fields' => $fields]) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4 p-0">
        {!! $this->makePartial('mailtemplates/variables', [
            'cssClass' => ' p-3',
            'variables' => resolve(\Igniter\System\Classes\MailManager::class)->listRegisteredVariables(),
        ]) !!}
    </div>
</div>
