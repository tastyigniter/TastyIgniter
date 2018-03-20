---
title: Contact
layout: default
permalink: /contact

'[contact]':
---
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <div class="contact-info">
                        <ul>
                            <li><strong><?= $contact->location->getName(); ?></strong></li>
                            <li><i class="fa fa-globe"></i><?= format_address($contact->location->getAddress()); ?></li>
                            <li><i class="fa fa-phone"></i><?= $contact->location->getTelephone(); ?></li>
                        </ul>
                    </div>

                    <h4 class="contact-title">
                        <?= lang('sampoyigi.frontend::default.contact.text_summary'); ?>
                    </h4>

                    <?= component('contact'); ?>
                </div>
            </div>
        </div>
    </div>
</div>