+function ($) {
    "use strict";

    // FORM WIDGET CLASS DEFINITION
    // ============================

    var FormWidget = function (element, options) {
        this.$el = $(element)
        this.$formTabs = this.$el.find('[data-control="form-tabs"]')
        this.options = options || {}
        this.fieldElementCache = null

        this.dependantUpdateInterval = 300
        this.dependantUpdateTimers = {}

        this.init()
    }

    FormWidget.prototype.init = function () {

        this.$form = this.$el.closest('form')

        this.registerHandlers()
        this.bindDependants()

        this.$el.find('[data-control="inputmask"]').inputmask();

        this.$el.one('dispose-control', $.proxy(this.dispose, this))
    }

    FormWidget.prototype.registerHandlers = function () {
        this.$formTabs.on('show.bs.tab', 'a[data-bs-toggle="tab"]', $.proxy(this.onTabShown, this))
    };

    FormWidget.prototype.dispose = function () {
        this.unbindDependants()

        this.$el.off('dispose-control', $.proxy(this.dispose, this))
        this.$el.removeData('ti.formWidget')

        this.$el = null
        this.$form = null
        this.options = null
        this.fieldElementCache = null
    }

    FormWidget.prototype.getFieldElements = function () {
        if (this.fieldElementCache !== null) {
            return this.fieldElementCache
        }

        var $form = this.$el,
            $nestedFields = $form.find('[data-control="formwidget"] [data-field-name]')

        return this.fieldElementCache = $form.find('[data-field-name]').not($nestedFields)
    }

    FormWidget.prototype.bindDependants = function () {
        var self = this,
            $fieldMap = this.getDependants()

        $.each($fieldMap, function (fieldName, toRefresh) {
            $(document).on('change.ti.formWidget', '[data-field-name="' + fieldName + '"]',
                $.proxy(self.onRefreshDependants, self, fieldName, toRefresh))
        })
    }

    FormWidget.prototype.unbindDependants = function () {
        var $fieldMap = this.getDependants()

        $.each($fieldMap, function (fieldName) {
            $(document).off('change.ti.formWidget', '[data-field-name="' + fieldName + '"]')
        })
    }

    FormWidget.prototype.getDependants = function () {
        if (!$('[data-field-depends]', this.$el).length) {
            return;
        }

        var $fieldMap = {},
            $fieldElements = this.getFieldElements()

        $fieldElements.filter('[data-field-depends]').each(function () {
            var name = $(this).data('field-name'),
                depends = $(this).data('field-depends')

            $.each(depends, function (index, depend) {
                if (!$fieldMap[depend]) {
                    $fieldMap[depend] = {fields: []}
                }

                $fieldMap[depend].fields.push(name)
            })
        })

        return $fieldMap
    }

    // EVENT HANDLERS
    // ============================

    FormWidget.prototype.onTabShown = function (event) {
        var selectedTab = $(event.target).attr('href')

        this.$form.request(this.options.alias + '::onActiveTab', {
            data: {tab: selectedTab}
        })
    }

    FormWidget.prototype.onRefreshDependants = function (fieldName, toRefresh) {
        var self = this,
            $formEl = this.$form,
            $fieldElements = this.getFieldElements()

        if (this.dependantUpdateTimers[fieldName] !== undefined) {
            window.clearTimeout(this.dependantUpdateTimers[fieldName])
        }

        this.dependantUpdateTimers[fieldName] = window.setTimeout(function () {
            var refreshData = $.extend({},
                toRefresh,
                paramToObj('data-refresh-data', self.options.refreshData)
            )

            $formEl.request(self.options.alias + '::onRefresh', {
                data: refreshData
            }).done(function () {
                $.each(toRefresh.fields, function (key, field) {
                    $('[data-field-name="' + field + '"]').trigger('change').progressIndicator('hide')
                })
            })
        }, this.dependantUpdateInterval)

        $.each(toRefresh.fields, function (index, field) {
            $fieldElements.filter('[data-field-name="' + field + '"]:visible')
                .addClass('progress-indicator-container size-form-field')
                .progressIndicator()
        })
    }

    FormWidget.DEFAULTS = {
        alias: null,
        refreshData: {}
    }

    // FORM WIDGET PLUGIN DEFINITION
    // ============================

    var old = $.fn.formWidget

    $.fn.formWidget = function (option) {
        var args = arguments,
            result

        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.formWidget')
            var options = $.extend({}, FormWidget.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.formWidget', (data = new FormWidget(this, options)))
            if (typeof option == 'string') result = data[option].call($this)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.formWidget.Constructor = FormWidget

    // FORM WIDGET NO CONFLICT
    // ============================

    $.fn.formWidget.noConflict = function () {
        $.fn.formWidget = old
        return this
    }

    // FORM WIDGET DATA-API
    // ============================

    function paramToObj(name, value) {
        if (value === undefined) value = ''
        if (typeof value == 'object') return value

        try {
            return JSON.parse(JSON.stringify(eval("({" + value + "})")))
        } catch (e) {
            throw new Error('Error parsing the ' + name + ' attribute value. ' + e)
        }
    }

    $(document).render(function () {
        $('[data-control="formwidget"]').formWidget();
    })

}(window.jQuery);
