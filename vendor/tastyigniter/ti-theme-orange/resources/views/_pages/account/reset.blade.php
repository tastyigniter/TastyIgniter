---
title: igniter.orange::default.account_reset_title
layout: default
permalink: /forgot-password/:code?
security: guest

'[igniter-orange::reset-password]': []
---
<div class="container">
    <div class="row">
        <div class="col-sm-6 mx-auto my-5">
            <div class="card border">
                <div class="card-body">
                    <h1 class="card-title h4 mb-4 font-weight-normal">
                        @lang('igniter.orange::default.account_reset_title')
                    </h1>

                    <livewire:igniter-orange::reset-password />
                </div>
            </div>
        </div>
    </div>
</div>
