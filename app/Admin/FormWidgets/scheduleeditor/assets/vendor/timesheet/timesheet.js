/**
 * TimeSheet.js [v1.0]
 * Li Bin
 */

(function ($) {

    /*
    * 表格中的单元格类
    * */
    var CSheetCell = function(opt){

        /*
         * opt : {
         *   state : 0 or 1,
         *   toggleCallback : function(curState){...}
         *   settingCallback : function(){...}
         * }
         *
         * */

        var cellPrivate = $.extend({
            state : 0,
            toggleCallback : false,
            settingCallback : false
        },opt);


        /*反向切换单元格状态*/
        this.toggle = function(){
            cellPrivate.state = cellPrivate.state>0 ? cellPrivate.state-1 : cellPrivate.state+1;
            if(cellPrivate.toggleCallback){
                cellPrivate.toggleCallback(cellPrivate.state);
            }
        }

        /*
        * 设置单元格状态
        * state : 0 or 1
        * */
        this.set = function(state){
            cellPrivate.state = state==0 ? 0 : 1;
            if(cellPrivate.settingCallback){
                cellPrivate.settingCallback();
            }
        }

        /*
        * 获取单元格状态
        * */
        this.get = function(){
            return cellPrivate.state;
        }

    }

    /*
    * 表格类
    * */
    var CSheet = function(opt){

        /*
        * opt : {
        *   dimensions : [8,9],  [行数，列数]
        *   sheetData : [[0,1,1,0,0],[...],[...],...]    sheet数据，二维数组，索引(a,b),a-行下标，b-列下标，每个cell只有0,1两态，与dimensions对应
        *   toggleCallback : function(){..}
        *   settingCallback : function(){..}
        * }
        *
        * */

        var sheetPrivate = $.extend({
            dimensions : undefined,
            sheetData : undefined,
            toggleCallback : false,
            settingCallback : false
        },opt);

        sheetPrivate.cells = [];

        /*
        * 初始化表格中的所有单元格
        * */
        sheetPrivate.initCells = function(){

            var rowNum = sheetPrivate.dimensions[0];
            var colNum = sheetPrivate.dimensions[1];

            if(sheetPrivate.dimensions.length==2 && rowNum>0 && colNum>0){
                for(var row= 0,curRow = []; row<rowNum; ++row){
                    curRow = [];
                    for(var col=0; col<colNum; ++col){
                        curRow.push(new CSheetCell({
                            state : sheetPrivate.sheetData ? (sheetPrivate.sheetData[row]?parseInt(sheetPrivate.sheetData[row][col]):0) : 0
                        }));
                    }
                    sheetPrivate.cells.push(curRow);
                }
            }else{
                throw new Error("CSheet : wrong dimensions");
            }
        }

        /*
        * 对给定的表各区域进行 toggle 或 set操作
        * */
        sheetPrivate.areaOperate = function(area,opt){

            /*
             * area : {
             *   startCell : [2,1],
             *   endCell : [7,6]
             * }
             * opt : {
             *    type:"set" or "toggle",
             *    state : 0 or 1 if type is set
             * }
             * */

            var rowCount = sheetPrivate.cells.length;
            var colCount = sheetPrivate.cells[0] ? sheetPrivate.cells[0].length : 0;
            var operationArea = $.extend({
                startCell : [0,0],
                endCell : [rowCount-1,colCount-1]
            },area);

            var isSheetEmpty = rowCount==0 || colCount==0;
            var isAreaValid = operationArea.startCell[0]>=0 && operationArea.endCell[0]<=rowCount-1 &&
                operationArea.startCell[1]>=0 && operationArea.endCell[1]<=colCount-1 &&                                             //operationArea不能超越sheet的边界
                operationArea.startCell[0]<=operationArea.endCell[0] && operationArea.startCell[1]<=operationArea.endCell[1];      //startCell必须居于endCell的左上方，或与之重合

            if(!isAreaValid){
                throw new Error("CSheet : operation area is invalid");
            }else if(!isSheetEmpty){
                for(var row=operationArea.startCell[0]; row<=operationArea.endCell[0]; ++row){
                    for(var col=operationArea.startCell[1]; col<=operationArea.endCell[1]; ++col){
                        if(opt.type=="toggle"){
                            sheetPrivate.cells[row][col].toggle();
                        }else if(opt.type=="set"){
                            sheetPrivate.cells[row][col].set(opt.state);
                        }
                    }
                }
            }

        }

        sheetPrivate.initCells();

        /*
        * 对表格的指定区域进行状态反向切换
        * toggleArea : {
         *   startCell : [2,1],
         *   endCell : [7,6]
         * }
        *
        * */
        this.toggle = function(toggleArea){

            sheetPrivate.areaOperate(toggleArea,{type:"toggle"});
            if(sheetPrivate.toggleCallback){
                sheetPrivate.toggleCallback();
            }

        }


        /*
        *  对表格的指定区域进行状态设置
        *  state : 0 or 1
        *  settingArea : {
         *   startCell : [2,1],
         *   endCell : [7,6]
         * }
        * */
        this.set = function(state,settingArea){

            sheetPrivate.areaOperate(settingArea,{type:"set",state:state});
            if(sheetPrivate.settingCallback){
                sheetPrivate.settingCallback();
            }
        }

        /*
         *  获取指定单元格的状态
         *  cellIndex ： [2,3]
         *  @return : 0 or 1
         * */
        this.getCellState = function(cellIndex){
            return sheetPrivate.cells[cellIndex[0]][cellIndex[1]].get();
        }

        /*
         *  获取指定行所有单元格的状态
         *  row ： 2
         *  @return : [1,0,...,1]
         * */
        this.getRowStates = function(row){
            var rowStates = [];
            for(var col=0; col<sheetPrivate.dimensions[1]; ++col){
                rowStates.push(sheetPrivate.cells[row][col].get());
            }
            return rowStates;
        }

        /*
         *  获取所有单元格的状态
         *  @return : [[1,0,...,1],[1,0,...,1],...,[1,0,...,1]]
         * */
        this.getSheetStates = function(){
            var sheetStates = [];
            for(var row= 0,rowStates = []; row<sheetPrivate.dimensions[0]; ++row){
                rowStates = [];
                for(var col=0; col<sheetPrivate.dimensions[1]; ++col){
                    rowStates.push(sheetPrivate.cells[row][col].get());
                }
                sheetStates.push(rowStates);
            }
            return sheetStates;
        }

    }
    


    $.fn.timeSheet = function(opt){

        /*
         *   说明 ：
         *
         *   TimeSheet 应该被绑定在 TBODY 元素上，其子元素有如下默认class:
         *
         *   表头 ---- class: .TimeSheet-head
         *   列表头 ---- class: .TimeSheet-colHead
         *   行表头 ---- class: .TimeSheet-rowHead
         *   单元格 ---- class: .TimeSheet-cell
         *
         *   用户可在传入的sheetClass下将元素的默认样式覆盖
         *   sheetClass将被赋予 TBODY 元素
         *
         *
         * opt :
         * {
         *      data : {
         *          dimensions : [7,8],
         *          colHead : [{name:"name1",title:"",style:"width,background,color,font"},{name:"name2",title:"",style:"width,background,color,font"},...]
         *          rowHead : [{name:"name1",title:"",style:"height,background,color,font"},{name:"name2",title:"",style:"height,background,color,font"},...]
         *          sheetHead : {name:"headName",style:"width,height,background,color,font"}
         *          sheetData : [[0,1,1,0,0],[...],[...],...]    sheet数据，二维数组，行主序，索引(a,b),a-行下标，b-列下标，每个cell只有0,1两态，与dimensions对应
         *      },
         *
         *      sheetClass : "",
         *      start : function(ev){...}
         *      end : function(ev, selectedArea){...}
         *      remarks : false
         * }
         *
         */

        var thisSheet = $(this);

        if(!thisSheet.is("TBODY")){
            throw new Error("TimeSheet needs to be bound on a TBODY element");
        }


        var sheetOption = $.extend({
            data: {},
            sheetClass: "",
            start: false,
            end : false,
            remarks : null
        }, opt);

        if(!sheetOption.data.dimensions || sheetOption.data.dimensions.length!==2 || sheetOption.data.dimensions[0]<0 || sheetOption.data.dimensions[1]<0){
            throw new Error("TimeSheet : wrong dimensions");
        }

        var operationArea = {
            startCell : undefined,
            endCell : undefined
        };

        var sheetModel = new CSheet({
            dimensions : sheetOption.data.dimensions,
            sheetData : sheetOption.data.sheetData ? sheetOption.data.sheetData : undefined
        });

        /*
        * 表格初始化
        * */
        var initSheet = function(){
            thisSheet.html("");
            thisSheet.addClass("TimeSheet");
            if(sheetOption.sheetClass){
                thisSheet.addClass(sheetOption.sheetClass);
            }
            initColHeads();
            initRows();
            repaintSheet();
        };

        /*
        * 初始化每一列的顶部表头
        * */
        var initColHeads = function(){
            var colHeadHtml = '<tr>';
            for(var i=0,curColHead=''; i<=sheetOption.data.dimensions[1]; ++i){
                if(i===0){
                    curColHead = '<td class="TimeSheet-head" style="'+(sheetOption.data.sheetHead.style?sheetOption.data.sheetHead.style:'')+'">'+sheetOption.data.sheetHead.name+'</td>';
                }else{
                    curColHead = '<td title="'+(sheetOption.data.colHead[i-1].title ? sheetOption.data.colHead[i-1].title:"")+'" data-col="'+(i-1)+'" class="TimeSheet-colHead '+(i===sheetOption.data.dimensions[1]?'rightMost':'')+'" style="'+(sheetOption.data.colHead[i-1].style ? sheetOption.data.colHead[i-1].style : '')+'">'+sheetOption.data.colHead[i-1].name+'</td>';
                }
                colHeadHtml += curColHead;
            }
            if(sheetOption.remarks){
                colHeadHtml += '<td class="TimeSheet-remarkHead">'+sheetOption.remarks.title+'</td>';
            }
            colHeadHtml += '</tr>';
            thisSheet.append(colHeadHtml);
        };

        /*
        * 初始化每一行
        * */
        var initRows = function(){
            for(var row=0,curRowHtml=''; row<sheetOption.data.dimensions[0]; ++row){
                curRowHtml='<tr class="TimeSheet-row">'
                for(var col= 0, curCell=''; col<=sheetOption.data.dimensions[1]; ++col){
                    if(col===0){
                        curCell = '<td title="'+(sheetOption.data.rowHead[row].title ? sheetOption.data.rowHead[row].title:"")+'"class="TimeSheet-rowHead '+(row===sheetOption.data.dimensions[0]-1?'bottomMost ':' ')+'" style="'+(sheetOption.data.rowHead[row].style ? sheetOption.data.rowHead[row].style : '')+'">'+sheetOption.data.rowHead[row].name+'</td>';
                    }else{
                        curCell = '<td class="TimeSheet-cell '+(row===sheetOption.data.dimensions[0]-1?'bottomMost ':' ')+(col===sheetOption.data.dimensions[1]?'rightMost':'')+'" data-row="'+row+'" data-col="'+(col-1)+'"></td>';
                    }
                    curRowHtml += curCell;
                }
                if(sheetOption.remarks){
                    curRowHtml += '<td class="TimeSheet-remark '+(row===sheetOption.data.dimensions[0]-1?'bottomMost ':' ')+'">'+sheetOption.remarks.default+'</td>';
                }
                curRowHtml += '</tr>';
                thisSheet.append(curRowHtml);
            }
        };

        /*
        * 比较两个单元格谁更靠近左上角
        * cell1:[2,3]
        * cell2:[4,5]
        * @return:{
             topLeft : cell1,
             bottomRight : cell2
         }
        * */
        var cellCompare = function(cell1,cell2){  //check which cell is more top-left
            var sum1 = cell1[0] + cell1[1];
            var sum2 = cell2[0] + cell2[1];

            if((cell1[0]-cell2[0])*(cell1[1]-cell2[1])<0){
                return {
                    topLeft : cell1[0]<cell2[0] ? [cell1[0],cell2[1]] : [cell2[0],cell1[1]],
                    bottomRight : cell1[0]<cell2[0] ? [cell2[0],cell1[1]] : [cell1[0],cell2[1]]
                };
            }

            return {
                topLeft : sum1<=sum2 ? cell1 : cell2,
                bottomRight : sum1>sum2 ? cell1 : cell2
            };
        };

        /*
        * 刷新表格
        * */
        var repaintSheet = function(){
            var sheetStates = sheetModel.getSheetStates();
            thisSheet.find(".TimeSheet-row").each(function(row,rowDom){
                var curRow = $(rowDom);
                curRow.find(".TimeSheet-cell").each(function(col,cellDom){
                    var curCell = $(cellDom);
                    if(sheetStates[row][col]===1){
                        curCell.addClass("TimeSheet-cell-selected");
                    }else if(sheetStates[row][col]===0){
                        curCell.removeClass("TimeSheet-cell-selected");
                    }
                });
            });
        };

        /*
        * 移除所有单元格的 TimeSheet-cell-selecting 类
        * */
        var removeSelecting = function(){
            thisSheet.find(".TimeSheet-cell-selecting").removeClass("TimeSheet-cell-selecting");
        };

        /*
        * 清空备注栏
        * */
        var cleanRemark = function(){
            thisSheet.find(".TimeSheet-remark").each(function(idx,ele){
                var curDom = $(ele);
                curDom.prop("title","");
                curDom.html(sheetOption.remarks.default);
            });
        };

        /*
        * 鼠标开始做选择操作
        * startCel ： [1,4]
        * */
        var startSelecting = function(ev,startCel){
            operationArea.startCell = startCel;
            if(sheetOption.start){
                sheetOption.start(ev);
            }
        };

        /*
         * 鼠标在选择操作过程中
         * topLeftCell ： [1,4]，      鼠标选择区域的左上角
         * bottomRightCell ： [3,9]      鼠标选择区域的右下角
         * */
        var duringSelecting = function(ev,topLeftCell,bottomRightCell){
            var curDom = $(ev.currentTarget);

            if(isSelecting && curDom.hasClass("TimeSheet-cell") || isColSelecting && curDom.hasClass("TimeSheet-colHead")){
                removeSelecting();
                for(var row=topLeftCell[0]; row<=bottomRightCell[0]; ++row){
                    for(var col=topLeftCell[1]; col<=bottomRightCell[1]; ++col){
                        $($(thisSheet.find(".TimeSheet-row")[row]).find(".TimeSheet-cell")[col]).addClass("TimeSheet-cell-selecting");
                    }
                }
            }
        };

        /*
         * 选择操作完成后
         * targetArea ： {
         *      topLeft ： [1,2],
         *      bottomRight: [3,8]
         * }
         * */
        var afterSelecting = function(ev,targetArea){
            var curDom = $(ev.currentTarget);
            var key = $(ev.which);
            var targetState = !sheetModel.getCellState(operationArea.startCell);

            //if(key[0]===1){       targetState = 1;}   //鼠标左键,将选定区域置1
            //else if(key[0]===3){ targetState = 0;}   //鼠标右键,将选定区域置0

            if(isSelecting && curDom.hasClass("TimeSheet-cell") || isColSelecting && curDom.hasClass("TimeSheet-colHead")){
                sheetModel.set(targetState,{
                    startCell : targetArea.topLeft,
                    endCell   : targetArea.bottomRight
                });
                removeSelecting();
                repaintSheet();
                if(sheetOption.end){
                    sheetOption.end(ev,targetArea);
                }
            }else{
                removeSelecting();
            }

            isSelecting = false;
            isColSelecting = false;
            operationArea = {
                startCell : undefined,
                endCell : undefined
            }
        };

        var isSelecting = false;  /*鼠标在表格区域做选择*/

        var isColSelecting = false; /*鼠标在列表头区域做选择*/

        var eventBinding = function(){

            /*防止重复绑定*/
            thisSheet.undelegate(".umsSheetEvent");

            /*表格开始选择*/
            thisSheet.delegate(".TimeSheet-cell","mousedown.umsSheetEvent",function(ev){
                var curCell = $(ev.currentTarget);
                var startCell = [curCell.data("row"),curCell.data("col")];
                isSelecting = true;
                startSelecting(ev,startCell);
            });

            /*表格选择完成*/
            thisSheet.delegate(".TimeSheet-cell","mouseup.umsSheetEvent",function(ev){
                if(!operationArea.startCell){
                    return;
                }
                var curCell = $(ev.currentTarget);
                var endCell = [curCell.data("row"),curCell.data("col")];
                var correctedCells = cellCompare(operationArea.startCell,endCell);
                afterSelecting(ev,correctedCells);
            });

            /*表格正在选择*/
            thisSheet.delegate(".TimeSheet-cell","mouseover.umsSheetEvent",function(ev){
                if(!isSelecting){
                    return;
                }
                var curCell = $(ev.currentTarget);
                var curCellIndex = [curCell.data("row"),curCell.data("col")];
                var correctedCells = cellCompare(operationArea.startCell,curCellIndex);
                var topLeftCell = correctedCells.topLeft;
                var bottomRightCell = correctedCells.bottomRight;

                duringSelecting(ev,topLeftCell,bottomRightCell);
            });


            /*列表头开始选择*/
            thisSheet.delegate(".TimeSheet-colHead","mousedown.umsSheetEvent",function(ev){
                var curColHead = $(ev.currentTarget);
                var startCell = [0,curColHead.data("col")];
                isColSelecting = true;
                startSelecting(ev,startCell);
            });

            /*列表头选择完成*/
            thisSheet.delegate(".TimeSheet-colHead","mouseup.umsSheetEvent",function(ev){
                if(!operationArea.startCell){
                    return;
                }
                var curColHead = $(ev.currentTarget);
                var endCell = [sheetOption.data.dimensions[0]-1,curColHead.data("col")];
                var correctedCells = cellCompare(operationArea.startCell,endCell);
                afterSelecting(ev,correctedCells);
            });

            /*列表头正在选择*/
            thisSheet.delegate(".TimeSheet-colHead","mouseover.umsSheetEvent",function(ev){
                if(!isColSelecting){
                    return;
                }
                var curColHead = $(ev.currentTarget);
                var curCellIndex = [sheetOption.data.dimensions[0]-1,curColHead.data("col")];
                var correctedCells = cellCompare(operationArea.startCell,curCellIndex);
                var topLeftCell = correctedCells.topLeft;
                var bottomRightCell = correctedCells.bottomRight;

                duringSelecting(ev,topLeftCell,bottomRightCell);
            });

            /*表格禁止鼠标右键菜单*/
            thisSheet.delegate("td","contextmenu.umsSheetEvent",function(ev){
                return false;
            });
        };


        initSheet();
        eventBinding();


        var publicAPI = {

            /*
            * 获取单元格状态
            * cellIndex ：[1,2]
            * @return : 0 or 1
            * */
            getCellState : function(cellIndex){
                return sheetModel.getCellState(cellIndex);
            },

            /*
             * 获取某行所有单元格状态
             * row ：2
             * @return : [1,0,0,...,0,1]
             * */
            getRowStates : function(row){
                return sheetModel.getRowStates(row);
            },

            /*
             * 获取表格所有单元格状态
             * @return : [[1,0,0,...,0,1],[1,0,0,...,0,1],...,[1,0,0,...,0,1]]
             * */
            getSheetStates : function(){
                return sheetModel.getSheetStates();
            },

            /*
            * 设置某行的说明文字
            * row : 2,
            * html : 说明
            * */
            setRemark : function(row,html){
                if($.trim(html)!==''){
                    $(thisSheet.find(".TimeSheet-row")[row]).find(".TimeSheet-remark").prop("title",html).html(html);
                }
            },

            /*
            * 重置表格
            * */
            clean : function(){
                sheetModel.set(0,{});
                repaintSheet();
                cleanRemark();
            },

            /*
            * 获取 default remark
            * */
            getDefaultRemark : function(){
                return sheetOption.remarks.default;
            },

            /*
            * 使表格不可操作
            * */
            disable : function(){
                thisSheet.undelegate(".umsSheetEvent");
            },

            /*
             * 使表格可操作
             * */
            enable : function(){
                eventBinding();
            },

            /*
            * 判断表格是否所有单元格状态都是1
            * @return ： true or false
            * */
            isFull : function(){
                for(var row=0; row<sheetOption.data.dimensions[0]; ++row){
                    for(var col=0; col<sheetOption.data.dimensions[1]; ++col){
                        if(sheetModel.getCellState([row,col])===0){
                            return false;
                        }
                    }
                }
                return true;
            }
        };

        return publicAPI;

    }


})(jQuery);
