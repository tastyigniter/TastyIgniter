---
title: main::account.address.text_heading
layout: default
permalink: /account/address/:id?

'[account]':
    security: customer

'[accountAddressBook]':
---
<div id="page-content">
	<div class="container top-spacing-20">
		<div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('sidebar/account'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountAddressBook'); ?>
            </div>
		</div>
	</div>
</div>
