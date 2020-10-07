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
            onLoad: function () {
                
                var $timesheetEl = $(".timesheet-editor"); 
                var $timesheetOptions = $timesheetEl.data();
                
                var data = [];
                for (var i=0; i<7; i++)
                {
                    var day = [];
                    if ($timesheetOptions.values[i] && $timesheetOptions.values[i].status){
                        var openHour = $timesheetOptions.values[i].open.split(':').map(function(v){ return parseInt(v) });               
                        var closeHour = $timesheetOptions.values[i].close.split(':').map(function(v){ return parseInt(v) }); 
                        var isOpen = false;
                        for (var j=0; j<24; j++) {
                            for (var k=0; k<60; k=k+15) {
                                if (openHour[0] == j && openHour[1] <= k){
                                    isOpen = true;
                                }
                                if (closeHour[0] == j && closeHour[1] <= k){
                                    isOpen = false;  
                                }
                                day.push(isOpen ? 1 : 0);    
                            }
                        }    
                    }
                    data.push(day);
                }
                
                var $timesheetInstance = $timesheetEl.TimeSheet({
                    data: {
                        dimensions: [7,24*4],
                        colHead: [
                            {name:"00",title:"00:00-00:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"00:15-00:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"00:30-00:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"00:45-01:00"},
                            {name:"01",title:"01:00-01:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"01:15-01:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"01:30-01:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"01:45-02:00"},
                            {name:"02",title:"02:00-02:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"02:15-02:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"02:30-02:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"02:45-03:00"},
                            {name:"03",title:"03:00-03:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"03:15-03:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"03:30-03:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"03:45-04:00"},
                            {name:"04",title:"04:00-04:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"04:15-04:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"04:30-04:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"04:45-05:00"},
                            {name:"05",title:"05:00-05:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"05:15-05:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"05:30-05:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"05:45-06:00"},
                            {name:"06",title:"06:00-06:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"06:15-06:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"06:30-06:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"06:45-07:00"},
                            {name:"07",title:"07:00-07:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"07:15-07:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"07:30-07:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"07:45-08:00"},
                            {name:"08",title:"08:00-08:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"08:15-08:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"08:30-08:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"08:45-09:00"},
                            {name:"09",title:"09:00-09:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"09:15-09:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"09:30-09:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"09:45-10:00"},
                            {name:"10",title:"10:00-10:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"10:15-10:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"10:30-10:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"10:45-11:00"},
                            {name:"11",title:"11:00-11:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"11:15-11:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"11:30-11:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"11:45-12:00"},
                            {name:"12",title:"12:00-12:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"12:15-12:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"12:30-12:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"12:45-13:00"},
                            {name:"13",title:"13:00-13:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"13:15-13:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"13:30-13:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"13:45-14:00"},
                            {name:"14",title:"14:00-14:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"14:15-14:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"14:30-14:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"14:45-15:00"},
                            {name:"15",title:"15:00-15:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"15:15-15:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"15:30-15:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"15:45-16:00"},
                            {name:"16",title:"16:00-16:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"16:15-16:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"16:30-16:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"16:45-17:00"},
                            {name:"17",title:"17:00-17:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"17:15-17:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"17:30-17:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"17:45-18:00"},
                            {name:"18",title:"18:00-18:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"18:15-18:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"18:30-18:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"18:45-19:00"},
                            {name:"19",title:"19:00-19:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"19:15-19:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"19:30-19:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"19:45-20:00"},
                            {name:"20",title:"20:00-20:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"20:15-20:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"20:30-20:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"20:45-21:00"},
                            {name:"21",title:"21:00-21:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"21:15-21:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"21:30-21:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"21:45-22:00"},
                            {name:"22",title:"22:00-22:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"22:15-22:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"22:30-22:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"22:45-23:00"},
                            {name:"23",title:"23:00-23:15"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"23:15-23:30"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"23:30-23:45"},{name:"&nbsp;&nbsp;&nbsp;&nbsp;",title:"23:45-00:00"},
                        ] ,
                        rowHead: $timesheetOptions.days,
                        sheetHead: {name:"Date\\Time"},
                        sheetData : data,
                    },
                    remarks: null,
                    end: function(){
                        var $value = [];                        
                        $timesheetInstance.getSheetStates().forEach(function(day, idx) {
                            var isOpen = false;
                            var myValue = [];
                            var openTime = '';
                            var closeTime = '';
                            
                            for (var j=0; j<24*4; j++)
                            {
                                if (day[j] === 1 && !isOpen)
                                {
                                    isOpen = true;
                                    openTime = Math.floor(j/4) + ':' + (j%4)*15;
                                    if (openTime.indexOf(':') == 1) openTime = '0' + openTime;
                                    if (openTime.length == 4) openTime += '0';
                                }
                                else if(day[j] === 0 && isOpen)
                                {
                                    isOpen = false;
                                    closeTime = Math.floor(j/4) + ':' + (j%4)*15;
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
                            $value.push(myValue);
                        });
                        
                        $('[name="' + $timesheetOptions.field + '"]').val(JSON.stringify($value));
                    }
                });
            }
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
