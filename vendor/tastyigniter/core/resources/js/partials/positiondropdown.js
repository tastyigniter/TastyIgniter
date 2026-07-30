+function ($) {
    'use strict';

    // position choices dropdown
    $(document).on('showDropdown', '.choices', (e) =>
        positionDropdown(e.target, '.choices', '.choices__list--dropdown', 'hideDropdown'));

    // position bootstrap dropdown
    $(document).on('show.bs.dropdown', '.dropdown', (e) =>
        positionDropdown(e.target, '.dropdown', '.dropdown-menu', 'hidden.bs.dropdown'));

    const positionDropdown = (eventTarget, dropdownClass, menuClass, onHideEventName) => {
        // update dropdown position only if parent has table-responsive class
        if (!$(eventTarget).closest('.table-responsive').length) {
            return;
        }
        const $dropdown = $(eventTarget).closest(dropdownClass),
            $dropdownMenu = $dropdown.find(menuClass),
            $scrollContainer = getScrollContainer($dropdown);

        cleanUpDropdownState($dropdownMenu, $scrollContainer, dropdownClass);

        // Delay the position update until old dropdowns are hidden
        const timeoutId = setTimeout(() => {
            updatePosition($dropdown, $dropdownMenu);
            // Update the position of the dropdown menu when the scroll container is scrolled
            $scrollContainer.on('scroll'+dropdownClass, () => updatePosition($dropdown, $dropdownMenu));

            // Update the position of the dropdown menu when the window is resized
            $(window).on('resize'+dropdownClass, () => updatePosition($dropdown, $dropdownMenu));
        }, 0);

        // Clean up the dropdown state when the dropdown is hidden
        $dropdown.on(onHideEventName, () => {
            clearTimeout(timeoutId);
            cleanUpDropdownState($dropdownMenu, $scrollContainer, dropdownClass);
        });
    }

    const updatePosition = ($dropdown, $dropdownMenu) => {
        // Check if elements still exist in DOM before updating position
        if (!$dropdown.length || !$dropdownMenu.length) {
            return;
        }

        // Calculate the position of the dropdown menu and set its styles
        const left = $dropdown.offset().left,
            menuInputWidth = $dropdown.outerWidth(),
            viewportHeight = $(window).height(),
            menuHeight = $dropdownMenu.outerHeight(),
            dropdownHeight = $dropdown.outerHeight();

        let top = $dropdown.offset().top+$dropdown.outerHeight();

        // If there's not enough space below, position menu above the dropdown
        const spaceBelow = viewportHeight-top;

        if (spaceBelow < menuHeight) {
            top -= menuHeight+dropdownHeight;
        }

        $dropdownMenu.css({
            position: 'fixed',
            inset: '0 auto auto 0',
            transform: `translate(${left}px, ${top}px)`,
            display: 'block',
            maxWidth: menuInputWidth+'px',
        });
    }

    // Get the scroll container for the dropdown element
    const getScrollContainer = ($element) => {
        let $parent = $element.parent();
        const skipSelectors = ['.table-responsive'];
        while ($parent.length) {
            if ($parent.is('body') || $parent.is('html')) {
                return $(window);
            }
            if ($parent.is(skipSelectors.join(','))) {
                $parent = $parent.parent();
                continue;
            }
            const overflowY = $parent.css('overflowY');
            const isScrollable = /(auto|scroll|overlay)/.test(overflowY);
            if (isScrollable && $parent[0].scrollHeight > $parent[0].clientHeight) {
                return $parent;
            }
            $parent = $parent.parent();
        }
        return $(window);
    }

    const cleanUpDropdownState = ($dropdownMenu, $scrollContainer, dropdownClass) => {
        $dropdownMenu.removeAttr('style');
        $scrollContainer.off('scroll'+dropdownClass);
        $(window).off('resize'+dropdownClass);
    }
}(window.jQuery)
