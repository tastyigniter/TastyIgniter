+function ($) {
    "use strict";

    var ScheduleEditor = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.editorModal = null

        this.init()
    }

    ScheduleEditor.prototype.constructor = ScheduleEditor

    ScheduleEditor.prototype.dispose = function () {
        this.editorModal.remove()
        this.editorModal = null
    }

    ScheduleEditor.prototype.init = function () {
        this.$el.on('click', '[data-editor-control]', $.proxy(this.onControlClick, this))
    }

    ScheduleEditor.prototype.loadRecordForm = function (event) {
        var $button = $(event.currentTarget)

        this.editorModal = new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $button.data('schedule-code'),
            onSave: function () {
                this.hide()
            },
            onLoad: this.onModalLoad.bind(this)
        })
    }

    // EVENT HANDLERS
    // ============================

    ScheduleEditor.prototype.onControlClick = function (event) {
        var control = $(event.currentTarget).data('editor-control')

        switch (control) {
            case 'load-schedule':
                this.loadRecordForm(event)
                break;
        }
    }

    ScheduleEditor.prototype.onModalLoad = function () {

        this.timesheetEl = $(".timesheet-editor");
        this.timesheetOptions = this.timesheetEl.data();

        var data = [];
        var initialRemarks = [];
        for (var dayOfWeek=0; dayOfWeek<7; dayOfWeek++)
        {
            var day = [];
            if (this.timesheetOptions.values[dayOfWeek])
            {
                // convert single opening/closing hours to multiple
                if (this.timesheetOptions.values[dayOfWeek].open)
                {
                    this.timesheetOptions.values[dayOfWeek].hours = [{
                        open: this.timesheetOptions.values[dayOfWeek].open,
                        close: this.timesheetOptions.values[dayOfWeek].close
                    }];
                    delete this.timesheetOptions.values[dayOfWeek].open;
                    delete this.timesheetOptions.values[dayOfWeek].close;
                }

                var isOpen = false;
                for (var hourOfDay=0; hourOfDay<24; hourOfDay++)
                {
                    for (var minuteOfDay=0; minuteOfDay<60; minuteOfDay=minuteOfDay+15)
                    {
                        for (var valueIterator=0; valueIterator<this.timesheetOptions.values[dayOfWeek].hours.length; valueIterator++)
                        {
                            var openHour = this.timesheetOptions.values[dayOfWeek].hours[valueIterator].open.split(':').map(function(v){ return parseInt(v) });
                            var closeHour = this.timesheetOptions.values[dayOfWeek].hours[valueIterator].close.split(':').map(function(v){ return parseInt(v) });

                            if (openHour[0] == hourOfDay && openHour[1] <= minuteOfDay){
                                isOpen = true;
                            }
                            if (closeHour[0] == hourOfDay && closeHour[1] <= minuteOfDay){
                                isOpen = false;
                            }
                        }
                        day.push(isOpen ? 1 : 0);
                    }
                }

                var remark = [];
                this.timesheetOptions.values[dayOfWeek].hours
                .forEach(function(hours) {
                    remark.push(hours.open + '-' + hours.close);
                });
                remark = remark.join(', ');
                initialRemarks.push(remark);

            }
            else {
                initialRemarks.push('-');
            }
            data.push(day);
        }

        this.dimensions = [7,24*4];

        var $headings = [];
        for (let hourOfDay=0; hourOfDay<24; hourOfDay++)
        {
            let hourPadded = hourOfDay.toString();
            if (hourPadded.length < 2) hourPadded = '0' + hourPadded;
            let nexthourPadded = (hourOfDay == 23 ? 0 : (hourOfDay + 1)).toString();
            if (nexthourPadded.length < 2) nexthourPadded = '0' + nexthourPadded;
            for (let minuteOfDay=0; minuteOfDay<60; minuteOfDay=minuteOfDay+15)
            {
                let minutePadded = minuteOfDay.toString();
                if (minutePadded.length < 2) minutePadded = '0' + minutePadded;
                $headings.push({
                    name: minuteOfDay==0 ? hourPadded : '&nbsp;&nbsp;&nbsp;&nbsp;',
                    title: hourPadded + ':' + minutePadded + '-' + (minuteOfDay==45 ? nexthourPadded + ':00' : hourPadded + ':' + (minuteOfDay+15)),
                })
            }
        }

        this.timesheetInstance = this.timesheetEl.timeSheet({
            data: {
                dimensions: this.dimensions,
                colHead: $headings,
                rowHead: this.timesheetOptions.days,
                sheetHead: {name:"Date\\Time"},
                sheetData : data,
            },
            remarks: {
                title : "-",
                default : '-',
            },
            end: this.onTimesheetEnd.bind(this)
        });

        initialRemarks.forEach(function(remark, idx){
            this.timesheetInstance.setRemark(idx, remark == '' ? '-' : remark);
        }, this);
    }

    ScheduleEditor.prototype.onTimesheetEnd = function(sheet){
        var $value = [];
        this.timesheetInstance.getSheetStates()
        .forEach(function(day, idx) {
            var isOpen = false;
            var myValue = [];
            var openTime = '';
            var closeTime = '';
            var remark = '';

            for (var dayIterator=0; dayIterator<this.dimensions[1]; dayIterator++)
            {
                if (day[dayIterator] === 1 && !isOpen)
                {
                    isOpen = true;
                    openTime = Math.floor(dayIterator/4) + ':' + (dayIterator%4)*15;
                    if (openTime.indexOf(':') == 1) openTime = '0' + openTime;
                    if (openTime.length == 4) openTime += '0';
                }
                else if(day[dayIterator] === 0 && isOpen)
                {
                    isOpen = false;
                    closeTime = Math.floor(dayIterator/4) + ':' + (dayIterator%4)*15;
                    if (closeTime.indexOf(':') == 1) closeTime = '0' + closeTime;
                    if (closeTime.length == 4) closeTime += '0';

                    myValue.push({
                        open: openTime,
                        close: closeTime
                    });

                    openTime = '';
                    closeTime = '';
                }
            }

            if (isOpen)
            {
                myValue.push({
                    open: openTime,
                    close: '00:00'
                });
            }

            $value.push({
                day: idx,
                hours: myValue,
                status: myValue.length > 0
            });

            if (myValue.length)
            {
                remark = [];
                myValue.forEach(function(hours) {
                    remark.push(hours.open + '-' + hours.close);
                });
                remark = remark.join(', ');
            }

            this.timesheetInstance.setRemark(idx, remark == '' ? '-' : remark);

        }, this);

        $('[name="' + this.timesheetOptions.field + '"]').val(JSON.stringify($value));

    }

    ScheduleEditor.DEFAULTS = {
        data: {},
        alias: undefined
    }

    // FormTable PLUGIN DEFINITION
    // ============================

    var old = $.fn.scheduleEditor

    $.fn.scheduleEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.scheduleEditor')
            var options = $.extend({}, ScheduleEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.scheduleEditor', (data = new ScheduleEditor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.scheduleEditor.Constructor = ScheduleEditor

    // ScheduleEditor NO CONFLICT
    // =================

    $.fn.scheduleEditor.noConflict = function () {
        $.fn.scheduleEditor = old
        return this
    }

    // ScheduleEditor DATA-API
    // ===============
    $(document).render(function () {
        $('[data-control="scheduleeditor"]').scheduleEditor()
    })
}(window.jQuery);
