window.OrangeCartItem = () => {
    return {
        minQuantity: 1,
        quantity: 1,
        price: 0,
        total: 0,
        comment: null,
        incrementQuantity() {
            this.quantity = Math.max(this.minQuantity, this.quantity+this.minQuantity);
            this.$wire.set('quantity', this.quantity, false);
        },
        decrementQuantity() {
            this.quantity = Math.max(this.minQuantity, this.quantity-this.minQuantity);
            this.$wire.set('quantity', this.quantity, false);
        },
        calculateTotal() {
            var menuPrice = parseFloat(this.price);

            [...this.$refs['item-options']?.querySelectorAll('[data-control="item-option"]') ?? []]
                .forEach((group) => {
                    const groupCap = parseInt(group.dataset.freeQuantityCap) || 0;
                    const entries = [];

                    [...group.querySelectorAll('input[data-option-price]:checked:not([disabled]), select:not([disabled]) option[data-option-price]:checked')]
                        .forEach((value) => {
                            entries.push({
                                id: +value.dataset.optionValueId,
                                qty: 1,
                                price: parseFloat(value.dataset.optionPrice),
                                freeQuantity: parseInt(value.dataset.freeQuantity) || 0,
                            });
                        });

                    [...group.querySelectorAll('[data-option-quantity] input[data-option-price]:not([disabled])')]
                        .forEach((value) => {
                            const quantity = parseInt(value._x_model?.get());
                            if (quantity > 0) {
                                entries.push({
                                    id: +value.dataset.optionValueId,
                                    qty: quantity,
                                    price: parseFloat(value.dataset.optionPrice),
                                    freeQuantity: parseInt(value.dataset.freeQuantity) || 0,
                                });
                            }
                        });

                    const freeQtyById = window.OrangeAllocateFreeQuantities(entries, groupCap);

                    entries.forEach((entry) => {
                        const chargeableQty = Math.max(0, entry.qty - (freeQtyById[entry.id] ?? 0));
                        menuPrice += chargeableQty * entry.price;
                    });
                });

            this.total = app.currencyFormat(this.quantity * menuPrice);

            Livewire.dispatch('cartItemTotalCalculated')
        },
        init() {
            this.minQuantity = parseFloat(this.$wire.get('minQuantity'));
            this.price = parseFloat(this.$wire.get('price'));
            this.quantity = parseInt(this.$wire.get('quantity'));
            this.comment = this.$wire.get('comment');

            this.$nextTick(() => {
                this.calculateTotal();
            })

            this.$watch('quantity', value => {
                this.calculateTotal();
            })
        }
    };
}
