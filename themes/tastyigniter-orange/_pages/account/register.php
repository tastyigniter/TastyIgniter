---
title: main::account.login.text_register_heading
layout: default
permalink: /register

'[account]':
    security: guest
---
<?php
$registrationTermsUrl = TRUE;
?>
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-section">
                    <h3><?= lang('main::account.login.text_register'); ?></h3>
                </div>

                <div id="register-form" class="content-wrap col-sm-6 center-block">
                    <?= partial('account::register'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
