<header id="main-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <button
                    type="button"
                    class="btn-navbar navbar-toggle"
                    data-toggle="collapse"
                    data-target="#main-header-menu-collapse"
                ><i class="fa fa-align-justify"></i></button>

                <?= partial('nav/logo'); ?>
            </div>

            <div class="col-sm-7">
                <div class="collapse navbar-collapse" id="main-header-menu-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a
                                href="<?= restaurant_url('local/menus'); ?>"
                                class="<?= ($this->page->getId() == 'local-menus') ? 'active' : ''; ?>"
                            ><?= lang('main::default.menu_menu'); ?></a>
                        </li>

                        <?php if (setting('reservation_mode') == '1') { ?>
                            <li>
                                <a
                                    href="<?= page_url('reservation'); ?>"
                                    class="<?= ($this->page->getId() == 'reservation-reservation') ? 'active' : ''; ?>"
                                ><?= lang('main::default.menu_reservation'); ?></a>
                            </li>
                        <?php } ?>

                        <?php if (Auth::isLogged()) { ?>
                            <li class="dropdown">
                                <a
                                    class="dropdown-toggle clickable"
                                    data-toggle="dropdown" id="dropdownLabel1"
                                ><?= lang('main::default.menu_my_account'); ?> <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownLabel">
                                    <li>
                                        <a
                                            role="presentation"
                                            href="<?= page_url('account/orders'); ?>"
                                            class="<?= ($this->page->getId() == 'account-orders') ? 'active' : ''; ?>"
                                        ><?= lang('main::default.menu_recent_order'); ?></a>
                                    </li>
                                    <li>
                                        <a
                                            role="presentation"
                                            href="<?= page_url('account/account'); ?>"
                                            class="<?= ($this->page->getId() == 'account-account') ? 'active' : ''; ?>"
                                        ><?= lang('main::default.menu_my_account'); ?></a>
                                    </li>
                                    <li>
                                        <a
                                            role="presentation"
                                            href="<?= page_url('account/address'); ?>"
                                            class="<?= ($this->page->getId() == 'account-address') ? 'active' : ''; ?>"
                                        ><?= lang('main::default.menu_address'); ?></a>
                                    </li>

                                    <?php if (setting('reservation_mode') == '1') { ?>
                                        <li>
                                            <a
                                                role="presentation"
                                                href="<?= page_url('account/reservations'); ?>"
                                                class="<?= ($this->page->getId() == 'account-reservations') ? 'active' : ''; ?>"
                                            ><?= lang('main::default.menu_recent_reservation'); ?></a>
                                        </li>
                                    <?php } ?>

                                    <li>
                                        <a
                                            role="presentation"
                                            data-request="account::onLogout"
                                        ><?= lang('main::default.menu_logout'); ?></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a
                                    href="<?= page_url('account/login'); ?>"
                                    class="<?= ($this->page->getId() == 'account-login') ? 'active' : ''; ?>"
                                ><?= lang('main::default.menu_login'); ?></a>
                            </li>
                            <li>
                                <a
                                    href="<?= page_url('account/register'); ?>"
                                    class="<?= ($this->page->getId() == 'account-register') ? 'active' : ''; ?>"
                                ><?= lang('main::default.menu_register'); ?></a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($headerPageList)) foreach ($headerPageList as $page) { ?>
                            <li>
                                <a
                                    href="<?= page_url('pages', ['slug' => $page->permalink_slug]); ?>"
                                ><?= $page->name; ?></a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
