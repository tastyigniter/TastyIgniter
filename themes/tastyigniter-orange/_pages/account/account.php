---
title: Account Dashboard
layout: default
permalink: /account

'[account]':
    security: customer

'[local]':

'[cartBox]':
---
<div id="page-content">
    <div class="container">
        <div class="row top-spacing">
            <div class="col-sm-3 col-md-3">
                <?= partial('sidebar/account'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('account'); ?>
            </div>
        </div>
    </div>
</div>
