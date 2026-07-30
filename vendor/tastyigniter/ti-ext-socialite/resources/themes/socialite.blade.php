---
title: Confirm your email address
layout: default
permalink: /confirm-email

'[session]':
security: guest

'[account]':

'[socialite]':
---
<div class="container">
    <div class="row">
        <div class="col-sm-6 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    @themePartial('socialite::confirm_email')
                </div>
            </div>
        </div>
    </div>
</div>
