<div id="<?= $this->getId('form-modal') ?>" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><?= $formTitle ? e(lang($formTitle)) : '' ?></h4>
            </div>
            <div class="modal-body">
                <div class="panel-group"
                     id="<?= $this->getId('form-modal-accordion') ?>"
                     role="tablist"
                     aria-multiselectable="true">
                    <?php $index = 0;
                    foreach ($payments as $payment) { ?>
                        <?php $index++; ?>
                        <div class="panel panel-default">
                            <div
                                class="panel-heading"
                                role="button"
                                data-toggle="collapse"
                                data-parent="#<?= $this->getId('form-modal-accordion') ?>"
                                href="#<?= $this->getId('form-modal-collapse-'.$index) ?>"
                                aria-expanded="true"
                                aria-controls="<?= $this->getId('form-modal-collapse-'.$index) ?>">
                                <h4 class="panel-title">
                                    <span><?= $payment->name ?></span>
                                    <p><?= $payment->description ?></p>
                                </h4>
                            </div>
                            <div
                                id="<?= $this->getId('form-modal-collapse-'.$index) ?>"
                                class="panel-collapse collapse <?php ($index == 1) ? 'in' : ''; ?>"
                                role="tabpanel">

                                <div class="panel-body">
                                    <?= var_dump($payment->data); ?>
                                    <!--                                    --><? //= $this->renderPaymentForm($payment); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Apply</button>
            </div>
        </div>
    </div>
</div>
