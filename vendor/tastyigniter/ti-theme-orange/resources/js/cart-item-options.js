/**
 * Allocates free units to selected option value entries, in the order given,
 * bounded by each entry's own freeQuantity budget and an optional shared
 * groupCap. Mirrors Igniter\Cart\Classes\CartManager::allocateFreeQuantities().
 *
 * @param {{id: number, qty: number, freeQuantity: number}[]} entries
 * @param {number} groupCap
 * @returns {Object<number, number>} id => free units granted
 */
window.OrangeAllocateFreeQuantities = (entries, groupCap) => {
    let remainingCap = groupCap > 0 ? groupCap : null
    const freeQtyById = {}

    entries.forEach(({ id, qty, freeQuantity }) => {
        if (!freeQuantity || qty < 1) return

        const grantable = Math.min(qty, freeQuantity, remainingCap === null ? Infinity : remainingCap)
        if (grantable < 1) return

        freeQtyById[id] = grantable
        if (remainingCap !== null) remainingCap -= grantable
    })

    return freeQtyById
}

window.OrangeCartItemOptions = (min, max, linkedValueIds = [], menuOptionId = null, freeQuantityCap = 0, freeLabel = 'Free', pricePrefix = '+') => {
    return {
        minSelection: min,
        maxSelection: max,
        linkedValueIds,
        menuOptionId,
        freeQuantityCap,
        freeLabel,
        pricePrefix,
        freeQtyById: {},
        freeQuantityUsed: 0,
        clearing: false,
        isVisible() {
            if (!this.linkedValueIds.length) return true
            const menuOptions = Object.values(this.$wire.menuOptions ?? {})
            return menuOptions.some((opt) => {
                const vals = [].concat(opt?.option_values ?? [])
                return vals.some((v) => this.linkedValueIds.includes(+v))
            })
        },
        collectSelectedEntries() {
            const selected = this.$wire.menuOptions?.[menuOptionId]?.option_values ?? []
            const inputs = [...this.$el.querySelectorAll('[data-free-quantity]')]
            const byId = new Map(inputs.map(($el) => [+$el.dataset.optionValueId, $el]))

            if (Array.isArray(selected)) {
                return selected
                    .map((id) => byId.get(+id))
                    .filter(Boolean)
                    .map(($el) => ({ id: +$el.dataset.optionValueId, qty: 1, freeQuantity: +$el.dataset.freeQuantity }))
            }

            return inputs
                .map(($el) => {
                    const qty = parseInt($el._x_model?.get() ?? $el.value ?? 0) || 0
                    return { id: +$el.dataset.optionValueId, qty, freeQuantity: +$el.dataset.freeQuantity }
                })
                .filter((entry) => entry.qty > 0)
        },
        computeFreeAllocation() {
            this.freeQtyById = window.OrangeAllocateFreeQuantities(this.collectSelectedEntries(), this.freeQuantityCap)
            this.freeQuantityUsed = Object.values(this.freeQtyById).reduce((sum, qty) => sum + qty, 0)
        },
        isValueFree(id) {
            return (this.freeQtyById[+id] ?? 0) > 0
        },
        /**
         * Formats an option value's price label, showing freeLabel when
         * every selected unit of it was granted a free allocation, or the
         * chargeable amount for the remaining (or all, if none free) units.
         */
        priceLabel(id, qty, price) {
            const free = this.freeQtyById[+id] ?? 0

            if (qty > 0 && free >= qty) {
                return this.freeLabel
            }

            const chargeableQty = qty > 0 ? Math.max(0, qty - free) : 1

            return this.pricePrefix + app.currencyFormat(chargeableQty * price)
        },
        toggleSelection() {
            if (this.maxSelection <= 0)
                return

            const selectedCount = this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:checked:not([disabled])').length

            ;[...this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:not(:checked)')]
                .forEach(($el) => {
                    selectedCount === this.maxSelection ? $el.setAttribute('disabled', 'disabled') : $el.removeAttribute('disabled')
                })
        },
        init() {
            if (this.linkedValueIds.length && this.menuOptionId !== null) {
                this.$watch(() => this.isVisible(), (visible) => {
                    if (visible || this.clearing) {
                        return
                    }
                    this.clearing = true

                    this.$wire.set(`menuOptions.${this.menuOptionId}.option_values`, [], false)

                    this.$el.querySelectorAll('input:not([type=hidden]):checked').forEach((input) => {
                        input.checked = false
                        input.dispatchEvent(new Event('change', { bubbles: true }))
                    })
                    this.$el.querySelectorAll('select').forEach((select) => {
                        select.value = ''
                        select.dispatchEvent(new Event('change', { bubbles: true }))
                    })

                    this.$nextTick(() => { this.clearing = false })
                })
            }

            Livewire.on('cartItemTotalCalculated', () => {
                this.toggleSelection()
                this.computeFreeAllocation()
            })

            this.$nextTick(() => this.computeFreeAllocation())

            $(this.$el).on('click', '[data-toggle="more-options"], [data-toggle="less-options"]', function (event) {
                var $el = $(event.currentTarget),
                    $container = $el.closest('[data-control="item-option"]')

                if ($el.data('toggle') == 'more-options') {
                    $el.fadeOut()
                    $container.find('[data-toggle="less-options"]').fadeIn()
                    $container.find('.hidden-item-options').fadeIn()
                } else {
                    $el.fadeOut()
                    $container.find('[data-toggle="more-options"]').fadeIn()
                    $container.find('.hidden-item-options').fadeOut()
                }
            })
        }
    }
}
