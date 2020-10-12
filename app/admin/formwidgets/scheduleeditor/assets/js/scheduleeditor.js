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
            onLoad: this.onModalLoad
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
        for (var i=0; i<7; i++)
        {
            var day = [];
            if (this.timesheetOptions.values[i])
            {
                // convert single opening/closing hours to multiple
                if (this.timesheetOptions.values[i].open)
                {
                    this.timesheetOptions.values[i].hours = [{
                        open: this.timesheetOptions.values[i].open, 
                        close: this.timesheetOptions.values[i].close
                    }];  
                    delete this.timesheetOptions.values[i].open;
                    delete this.timesheetOptions.values[i].close;  
                }
                
                var isOpen = false;
                for (var j=0; j<24; j++)
                {
                    for (var k=0; k<60; k=k+15)
                    {
                        for (var l=0; l<this.timesheetOptions.values[i].hours.length; l++)
                        {
                            var openHour = this.timesheetOptions.values[i].hours[l].open.split(':').map(function(v){ return parseInt(v) });               
                            var closeHour = this.timesheetOptions.values[i].hours[l].close.split(':').map(function(v){ return parseInt(v) }); 
                            
                            if (openHour[0] == j && openHour[1] <= k){
                                isOpen = true;
                            }
                            if (closeHour[0] == j && closeHour[1] <= k){
                                isOpen = false;  
                            }
                        }
                        day.push(isOpen ? 1 : 0);    
                    }
                }  
                
                var remark = [];
                this.timesheetOptions.values[i].hours
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
        
        var $dimensions = [7,24*4];
        
        var $headings = [];
        for (let i=0; i<24; i++)
        {
            let iPadded = i.toString();
            if (iPadded.length < 2) iPadded = '0' + iPadded;
            let nextiPadded = (i == 23 ? 0 : (i + 1)).toString();
            if (nextiPadded.length < 2) nextiPadded = '0' + nextiPadded;
            for (let j=0; j<60; j=j+15)
            {
                let jPadded = j.toString();
                if (jPadded.length < 2) jPadded = '0' + jPadded;
                $headings.push({
                    name: j==0 ? iPadded : '&nbsp;&nbsp;&nbsp;&nbsp;',
                    title: iPadded + ':' + jPadded + '-' + (j==45 ? nextiPadded + ':00' : iPadded + ':' + (j+15)),
                })
            }
        }
        
        this.timesheetInstance = this.timesheetEl.timeSheet({
            data: {
                dimensions: $dimensions,
                colHead: $headings,
                rowHead: this.timesheetOptions.days,
                sheetHead: {name:"Date\\Time"},
                sheetData : data,
            },
            remarks: {
                title : "-",
                default : '-',
            },
            end: this.onTimesheetEnd
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
            
            for (var j=0; j<$dimensions[1]; j++)
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
            
            $value.push({
                day: idx,
                hours: myValue,
                status: hours.length > 0
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
            
        });
        
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
