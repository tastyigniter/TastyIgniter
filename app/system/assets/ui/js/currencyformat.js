+function ($) {
    "use strict";

    // CURRENCY HELPER FUNCTION DEFINITION
    // ============================

    if (!app)
        return;

    app.currencyFormat = function (amount) {

        if (!app.currency)
            throw 'Currency values not defined in app scope';

        return currency(amount, {
            decimal: app.currency.decimal_sign,
            precision: app.currency.decimal_precision,
            separator: app.currency.thousand_sign,
            symbol: app.currency.symbol,
            pattern: app.currency.symbol_position ? '#!' : '!#',
        }).format();

    };

}(window.jQuery);
