---
title: main::default.local.text_heading
layout: local
permalink: /locations

'[localList]':
---
<div id="page-content">
	<div class="container">
		<div class="row">
            <?= component('localList::filter'); ?>

            <div class="location-list col-sm-9">
                <?= component('localList'); ?>
            </div>
		</div>
	</div>
</div>
