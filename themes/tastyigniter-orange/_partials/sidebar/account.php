<div class="list-group list-group-responsive">
    <a
        href="<?= site_url('account/account'); ?>"
        class="list-group-item <?= ($this->page->getId() == 'account-account') ? 'active' : ''; ?>"
    >
        <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_account'); ?>
    </a>
    <a
        href="<?= site_url('account/details'); ?>"
        class="list-group-item <?= ($this->page->getId() == 'account-details') ? 'active' : ''; ?>"
    >
        <span class="fa fa-edit"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_edit_details'); ?>
    </a>
    <a
        href="<?= site_url('account/address'); ?>"
        class="list-group-item <?= ($this->page->getId() == 'account-address') ? 'active' : ''; ?>"
    >
        <span class="fa fa-book"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_address'); ?>
    </a>
    <a
        href="<?= site_url('account/orders'); ?>"
        class="list-group-item <?= ($this->page->getId() == 'account-orders') ? 'active' : ''; ?>"
    >
        <span class="fa fa-list-alt"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_orders'); ?>
    </a>

    <?php if ((int)setting('reservation_mode', 1)) { ?>
        <a
            href="<?= site_url('account/reservations'); ?>"
            class="list-group-item <?= ($this->page->getId() == 'account-reservations') ? 'active' : ''; ?>"
        >
            <span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_reservations'); ?>
        </a>
    <?php } ?>

    <?php if ((int)setting('allow_reviews', 1)) { ?>
        <a
            href="<?= site_url('account/reviews'); ?>"
            class="list-group-item <?= ($this->page->getId() == 'account-reviews') ? 'active' : ''; ?>"
        >
            <span class="fa fa-star"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_reviews'); ?>
        </a>
    <?php } ?>

    <a
        href="<?= site_url('account/inbox'); ?>"
        class="list-group-item <?= ($this->page->getId() == 'account-inbox') ? 'active' : ''; ?>"
    >
        <span class="fa fa-inbox"></span>&nbsp;&nbsp;&nbsp;<?= sprintf(lang('sampoyigi.account::default.text_inbox'), empty($inboxCount) ? '' : $inboxCount); ?>
    </a>
    <a
        href="<?= site_url('account/logout'); ?>"
        class="list-group-item  list-group-item-danger"><span class="fa fa-ban"></span>&nbsp;&nbsp;&nbsp;<?= lang('sampoyigi.account::default.text_logout'); ?>
    </a>
</div>
