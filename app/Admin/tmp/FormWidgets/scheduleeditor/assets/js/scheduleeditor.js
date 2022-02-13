+function ($) {
    "use strict";

    var ScheduleEditor = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.editorModal = null
        this.timesheet = null

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

    ScheduleEditor.prototype.initTimesheet = function () {
        var $timesheet = $(this.options.timesheetSelector),
            timesheetOptions = $timesheet.data(),
            timesheetHeadings = this.getTimesheetHeadings(),
            timesheetData = this.parseTimesheetData()

        this.timesheet = $timesheet.find('table > tbody').timeSheet({
            data: {
                dimensions: [this.options.timesheetYCount, this.options.timesheetXCount * 60 / timesheetOptions.cellDuration],
                colHead: timesheetHeadings,
                rowHead: timesheetOptions.days,
                sheetHead: {name: this.options.timesheetHeadText},
                sheetData: timesheetData.data,
            },
            remarks: {title: '', default: this.options.timesheetEmptyText},
            end: $.proxy(this.onTimesheetEnd, this)
        });

        timesheetData.remarks.forEach(function (remark, idx) {
            this.timesheet.setRemark(idx, remark === '' ? '-' : remark);
        }, this);

        this.onTimesheetEnd()
    }

    ScheduleEditor.prototype.loadRecordForm = function (event) {
        var $button = $(event.currentTarget)

        this.editorModal = new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $button.data('schedule-code'),
            onLoad: $.proxy(this.onModalLoad, this),
            onSave: function () {
                this.hide()
            }
        })
    }

    ScheduleEditor.prototype.getTimesheetHeadings = function () {
        var timesheetOptions = $(this.options.timesheetSelector).data(),
            result = [];

        for (let hourOfDay = 0; hourOfDay < 24; hourOfDay++) {
            let hourPadded = hourOfDay.toString();
            let nextHourPadded = (hourOfDay === 23 ? 0 : (hourOfDay + 1)).toString();

            if (hourPadded.length < 2) hourPadded = '0' + hourPadded;
            if (nextHourPadded.length < 2) nextHourPadded = '0' + nextHourPadded;

            for (let minuteOfDay = 0; minuteOfDay < 60; minuteOfDay = minuteOfDay + timesheetOptions.cellDuration) {
                let minutePadded = minuteOfDay.toString();

                if (minutePadded.length < 2) minutePadded = '0' + minutePadded;

                result.push({
                    name: (hourOfDay % 4 === 0) ? hourPadded : '&nbsp;&nbsp;&nbsp;&nbsp;',
                    title: hourPadded + ':' + minutePadded + '-' + (minuteOfDay === (60 - timesheetOptions.cellDuration) ? nextHourPadded + ':00' : hourPadded + ':' + (minuteOfDay + (60 / timesheetOptions.cellDuration))),
                })
            }
        }

        return result;
    }

    ScheduleEditor.prototype.parseTimesheetData = function () {
        var timesheetOptions = $(this.options.timesheetSelector).data(),
            result = {
                data: [],
                remarks: [],
            }

        for (var dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
            var day = [];
            if (timesheetOptions.values[dayOfWeek]) {
                var timesheetHours = timesheetOptions.values[dayOfWeek].hours;
                var isOpen = false;
                for (var hourOfDay = 0; hourOfDay < 24; hourOfDay++) {
                    for (var minuteOfDay = 0; minuteOfDay < 60; minuteOfDay = minuteOfDay + timesheetOptions.cellDuration) {
                        for (var valueIterator = 0; valueIterator < timesheetHours.length; valueIterator++) {
                            var openHour = timesheetHours[valueIterator].open.split(':').map(function (v) {
                                return parseInt(v)
                            });
                            var closeHour = timesheetHours[valueIterator].close.split(':').map(function (v) {
                                return parseInt(v)
                            });

                            if (openHour[0] === hourOfDay && openHour[1] <= minuteOfDay) {
                                isOpen = true;
                            }
                            if (closeHour[0] === hourOfDay && closeHour[1] <= minuteOfDay) {
                                isOpen = false;
                            }
                        }
                        day.push(isOpen ? 1 : 0);
                    }
                }

                var remark = [];
                timesheetOptions.values[dayOfWeek].hours.forEach(function (hours) {
                    remark.push(hours.open + '-' + hours.close);
                });
                remark = remark.join(', ');
                result.remarks.push(remark);

            } else {
                result.remarks.push('-');
            }
            result.data.push(day);
        }

        return result
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
        this.initTimesheet()
    }

    ScheduleEditor.prototype.onTimesheetEnd = function (sheet) {
        var $value = [],
            timesheetOptions = $(this.options.timesheetSelector).data(),
            minuteDivisor = (60 / timesheetOptions.cellDuration);

        this.timesheet.getSheetStates().forEach(function (day, idx) {
            var isOpen = false;
            var myValue = [];
            var openTime = '';
            var closeTime = '';
            var remark = '';

            for (var dayIterator = 0; dayIterator < this.options.timesheetXCount; dayIterator++) {
                if (day[dayIterator] === 1 && !isOpen) {
                    isOpen = true;
                    openTime = Math.floor(dayIterator / minuteDivisor) + ':' + (dayIterator % minuteDivisor) * (60 / timesheetOptions.cellDuration);
                    if (openTime.indexOf(':') === 1) openTime = '0' + openTime;
                    if (openTime.length === 4) openTime += '0';
                } else if (day[dayIterator] === 0 && isOpen) {
                    isOpen = false;
                    closeTime = Math.floor(dayIterator / minuteDivisor) + ':' + (dayIterator % minuteDivisor) * (60 / timesheetOptions.cellDuration);
                    if (closeTime.indexOf(':') === 1) closeTime = '0' + closeTime;
                    if (closeTime.length === 4) closeTime += '0';

                    myValue.push({
                        open: openTime,
                        close: closeTime
                    });

                    openTime = '';
                    closeTime = '';
                }
            }

            if (isOpen) {
                myValue.push({
                    open: openTime,
                    close: '23:59'
                });
            }

            $value.push({
                day: idx,
                hours: myValue,
                status: myValue.length > 0
            });

            if (myValue.length) {
                remark = [];
                myValue.forEach(function (hours) {
                    remark.push(hours.open + '-' + hours.close);
                });
                remark = remark.join(', ');
            }

            this.timesheet.setRemark(idx, remark === '' ? '-' : remark);

        }, this);

        $('[name="' + timesheetOptions.fieldName + '"]').val(JSON.stringify($value));
    }

    ScheduleEditor.DEFAULTS = {
        data: {},
        alias: undefined,
        timesheetSelector: '[data-control="timesheet"]',
        timesheetHeadText: "Date\\Time",
        timesheetEmptyText: '-',
        timesheetXCount: 24,
        timesheetYCount: 7,
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
