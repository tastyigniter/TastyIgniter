<div>
    @unless($hideMenuSearch)
        <div class="menu-search pb-4">
            @include('igniter-orange::includes.menu.search')
        </div>
    @endunless

    <div class="menu-list">
        @if (!$selectedCategorySlug && $isGrouped)
            @include('igniter-orange::includes.menu.grouped', ['groupedMenuItems' => $menuList])
        @else
            @include('igniter-orange::includes.menu.items', ['menuItems' => $menuList])
        @endif

        @if($itemsPerPage > 0)
            <div class="pagination-bar text-right">
                <div class="links">{{ $menuList->links('igniter-orange::pagination.simple_default') }}</div>
            </div>
        @endif
    </div>

    @if($selectedMenuId)
        <button
            x-data="OrangeShowSelectedMenuItemModal()"
            x-ref="selectedMenuItemTrigger"
            type="button"
            class="d-none"
            data-toggle="orange-modal"
            data-component="igniter-orange::cart-item-modal"
            data-arguments='{"menuId": {{ $selectedMenuId }}}'
        ></button>
    @endif
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        document.querySelectorAll('[data-control="menu-item"]').forEach((el) => {
            el.addEventListener('click', (event) => {
                if (el.classList.contains('disabled')) {
                    event.preventDefault();
                    return;
                } else {
                    el.classList.add('disabled');
                }

                el.querySelectorAll('i').forEach((icon) => {
                    if (icon.hasAttribute('wire:loading.class')) {
                        icon.classList.add('fa-spinner', 'fa-spin');
                    }
                });
            });
        });
    })
    Livewire.hook('commit', ({respond}) => {
        respond(() => {
            document.querySelectorAll('[data-control="menu-item"]').forEach((el) => {
                el.classList.remove('disabled');
                el.querySelectorAll('i.fa-spin').forEach((icon) => {
                    if (icon.hasAttribute('wire:loading.class')) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                    }
                })
            });
        })
    });
    $(function () {
        let scrollSpyTimer = null;

        $(document).on('activate.bs.scrollspy', function (e) {
            // Reset the timer for "final" activation
            clearTimeout(scrollSpyTimer);

            scrollSpyTimer = setTimeout(function () {
                const $nav = $('#navbar-categories');
                const $active = $(e.relatedTarget);

                if (!$active?.length) return;

                const left = $active.position().left;
                const right = left + $active.outerWidth();

                if (left < 0 || right > $nav.width()) {
                    $active[0].scrollIntoView({
                        behavior: 'smooth',
                        inline: 'center',
                        block: 'nearest'
                    });
                }
            }, 250); // Delay tuned: waits for scrolling & anchor snapping to settle
        });

        // Keep last active nav-link highlighted when no section is in view
        let lastActive = null;
        $(document)
            .on('activate.bs.scrollspy', e => {
                lastActive = $(e.relatedTarget);
            })
            .on('scroll', () => {
                if (!$('#navbar-categories .nav-link.active').length && lastActive) {
                    lastActive.addClass('active');
                }
            });

        // Smooth scroll to anchor links
        $('a[href*="#"]:not([href="#"])').click(function (event) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var $target = $(this.hash);
                $target = $target.length ? $target : $('[name='+this.hash.slice(1)+']');
                if ($target.length) {
                    event.preventDefault()
                    var offset = $('.sticky-top').outerHeight() || 0;
                    $('html, body').animate({
                        scrollTop: $target.offset().top-offset
                    }, 500, function () {
                        $('[data-bs-toggle="collapse"]:is(.collapsed)', $target).trigger('click');
                        var spy = bootstrap.ScrollSpy.getInstance($target.closest('[data-bs-spy="scroll"]'));
                        if (spy) spy.refresh();
                    });
                }

                return false;
            }
        });
    });
</script>
@endscript
