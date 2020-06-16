/*
 * Daterange plugin
 *
 * Data attributes:
 * - data-control="daterange" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CHART CONTROL CLASS DEFINITION
    // ============================

    var DateRangeControl = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.rangePicker = null

        // Init
        this.initDateRange();
    }

    DateRangeControl.DEFAULTS = {
        opens: 'left',
        parentEl: '.filter-scope',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        timePicker: true,
        rangeFormat: 'MMMM D, YYYY',
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }

    DateRangeControl.prototype.initDateRange = function () {
        var options = DateRangeControl.DEFAULTS
        options.parentEl = this.options.rangeParentSelector
        this.$el.daterangepicker(options, $.proxy(this.onRangeSelected, this))
        this.rangePicker = this.$el.data('daterangepicker');
        
        var value = this.$el.val();
        if (value != '') {
	        value = value.split('|');
        	this.onRangeSelected(moment(value[0]), moment(value[1]), null, true);
	    } else {
	        this.onRangeSelected(DateRangeControl.DEFAULTS.startDate, DateRangeControl.DEFAULTS.endDate, null, true)
	    }
    }
    
    DateRangeControl.prototype.onRangeSelected = function (start, end, label, initialize) {
        $('span', this.$el).html(start.format(this.options.rangeFormat)
            + ' - ' + end.format(this.options.rangeFormat));
            
        this.$el.prev('[data-datepickertype="start"]').val(start.format('YYYY-MM-DD HH:mm:ss') + '|' + end.format('YYYY-MM-DD HH:mm:ss'));
            
        if (!initialize) this.$el.closest('form').submit();
    }

    DateRangeControl.prototype.unbind = function () {
        this.$el.dateRangeControl('destroy')
        this.$el.removeData('ti.dateRangeControl')
        this.chartJs = null
    }

    // FIELD DATERANGE CONTROL PLUGIN DEFINITION
    // ============================

    var old = $.fn.dateRangeControl

    $.fn.dateRangeControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.dateRangeControl')
            var options = $.extend({}, DateRangeControl.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.dateRangeControl', (data = new DateRangeControl(this, options)))
            if (typeof option === 'string') result = data[option].apply(data, args)
            if (typeof result !== 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.dateRangeControl.Constructor = DateRangeControl

    // FIELD DATERANGE CONTROL NO CONFLICT
    // =================

    $.fn.dateRangeControl.noConflict = function () {
        $.fn.dateRangeControl = old
        return this
    }

    // FIELD DATERANGE CONTROL DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="daterange"]').dateRangeControl()
    })
}(window.jQuery)