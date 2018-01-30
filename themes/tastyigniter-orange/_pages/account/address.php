---
title: main::account.address.text_heading
layout: default
permalink: /account/address

'[account]':
    context: user

'[accountAddressBook]':
---
<div id="page-content">
	<div class="container top-spacing-20">
		<div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('account::sidebar'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountAddressBook'); ?>
            </div>
		</div>
	</div>
</div>
