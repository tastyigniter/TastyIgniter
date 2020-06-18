/*
 * Datepicker plugin
 *
 * Data attributes:
 * - data-control="datePicker" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CHART CONTROL CLASS DEFINITION
    // ============================

    var DateControl = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.rangePicker = null

        // Init
        this.initDateRange();
    }

    DateControl.DEFAULTS = {
        opens: 'left',
        autoUpdateInput: false,
        parentEl: '.filter-scope',
        startDate: moment(),
        endDate: moment(),
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: false,
        dateFormat: 'MMMM D, YYYY',
    }

    DateControl.prototype.initDateRange = function () {
        var options = DateControl.DEFAULTS
        options.parentEl = this.options.rangeParentSelector
        this.rangePicker = this.$el.data('daterangepicker');
        
        var value = this.$el.val();
        if (value != '') {
	        options.startDate = moment(value);
        }
	    	    
        this.$el.daterangepicker(options, $.proxy(this.onDateSelected, this))
        this.onDateSelected(options.startDate, null, null, true);
    }
    
    DateControl.prototype.onDateSelected = function (start, end, label, initialize) {
        this.$el.val(start.format(this.options.dateFormat));
        this.$el.prev('[data-datepicker-value]').val(start.format('YYYY-MM-DD'));
        if (!initialize) this.$el.closest('form').submit();
    }

    DateControl.prototype.unbind = function () {
        this.$el.dateControl('destroy')
        this.$el.removeData('ti.dateControl')
        this.chartJs = null
    }

    // FIELD DATERANGE CONTROL PLUGIN DEFINITION
    // ============================

    var old = $.fn.dateControl

    $.fn.dateControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.dateControl')
            var options = $.extend({}, DateControl.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.dateControl', (data = new DateControl(this, options)))
            if (typeof option === 'string') result = data[option].apply(data, args)
            if (typeof result !== 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.dateControl.Constructor = DateControl

    // FIELD DATERANGE CONTROL NO CONFLICT
    // =================

    $.fn.dateControl.noConflict = function () {
        $.fn.dateControl = old
        return this
    }

    // FIELD DATERANGE CONTROL DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="datepicker"]').dateControl()
    })
}(window.jQuery)