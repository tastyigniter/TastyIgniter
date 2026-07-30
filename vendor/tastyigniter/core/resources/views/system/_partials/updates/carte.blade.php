<div id="carte-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('igniter::system.updates.text_title_carte')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body wrap-none">
                @isset($carteInfo['owner'])
                    <div id="carte-details">
                        {!! $this->makePartial('updates/carte_info', ['carteInfo' => $carteInfo]) !!}
                        {!! $this->makePartial('updates/carte_licence_alert', ['carteInfo' => $carteInfo]) !!}
                    </div>
                @endisset
                <div
                    class="p-3 carte-body border-top"
                    style="display: {{ isset($carteInfo) ? 'none' : 'block' }};"
                >
                    {!! form_open(current_url(), [
                        'id' => 'carte-form',
                        'role' => 'form',
                        'method' => 'POST',
                    ]) !!}
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="carte_key"
                            placeholder="Enter your carte key..."
                            autocomplete="off"
                        />
                        <a
                            class="btn btn-light btn-carte-help"
                            onclick="$('#carte-help').slideToggle()"
                        ><i class="fa fa-question-circle"></i></a>
                    </div>
                    <button
                        id="update-carte"
                        class="btn btn-primary w-100 mt-3"
                        type="button"
                    >@lang('igniter::system.updates.button_attach_carte')</button>
                    {!! form_close() !!}
                    <div
                        id="carte-help"
                        class="wrap-horizontal"
                    >{!! lang('igniter::system.updates.help_carte_key') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
