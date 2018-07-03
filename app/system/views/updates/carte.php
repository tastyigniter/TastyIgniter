<div id="carte-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang('system::lang.updates.text_title_carte'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body wrap-none">
                <div class="panel panel-light panel-carte">
                    <div id="carte-details">
                        <?= $this->makePartial('updates/carte_info', ['carteInfo' => $carteInfo]); ?>
                    </div>
                    <div class="panel-footer">
                        <?= form_open(current_url(),
                            [
                                'id'     => 'carte-form',
                                'role'   => 'form',
                                'method' => 'POST',
                            ]
                        ); ?>
                        <div class="input-group">
                            <input type="text"
                                   class="form-control"
                                   name="carte_key"
                                   placeholder="Enter your carte key...">
                            <span class="input-group-btn">
                                <a
                                    class="btn btn-outline-default btn-carte-help"
                                    onclick="$('#carte-help').slideToggle()"
                                >
                                    <i class="fa fa-question-circle"></i>
                                </a>
                                <button
                                    id="update-carte"
                                    class="btn btn-primary"
                                    type="button"><i class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                        <?= form_close(); ?>
                        <div
                            id="carte-help"
                            class="wrap-horizontal"
                            style="display: <?= $carteInfo ? 'none' : 'block'; ?>;"><?= lang('system::lang.updates.help_carte_key'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
