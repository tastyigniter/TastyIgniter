---
title: igniter.orange::default.reservation_title
layout: default
permalink: ':location/reservation'

'[igniter-orange::booking]': []
---
<div class="container pt-4 pb-5">
    <div class="card mb-1 bg-white">
        <div class="card-body">
            <div class="mb-3" wire:ignore>
                <a
                    class="text-decoration-none"
                    href="{{page_url('locations')}}"
                >
                    <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                    @lang('igniter.orange::default.button_back')
                </a>
            </div>

            <x-igniter-orange::local-header current-page="reservation.reservation" />
        </div>
    </div>
    <livewire:igniter-orange::booking/>
</div>
