(function($) {
  "use strict";
  $.fn.bsPhotoGallery = function(options) {

      var settings = $.extend({}, $.fn.bsPhotoGallery.defaults, options);
      var id = generateId();
      var classesString = settings.classes;
      var classesArray = classesString.split(" ");
      var clicked = {};

      function getCurrentUl(){
        return 'ul[data-bsp-ul-id="'+clicked.ulId+'"][data-bsp-ul-index="'+clicked.ulIndex+'"]';
      }
      function generateId() {
        //http://fiznool.com/blog/2014/11/16/short-id-generation-in-javascript/
        var ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var ID_LENGTH = 4;
        var out = '';
        for (var i = 0; i < ID_LENGTH; i++) {
          out += ALPHABET.charAt(Math.floor(Math.random() * ALPHABET.length));
        }
        return 'bsp-'+out;
      }
      function createModalWrap(){

        if($('#bsPhotoGalleryModal').length !== 0){
          return false;
        }

        var modal = '';
        modal += '<div class="modal fade" id="bsPhotoGalleryModal" tabindex="-1" role="dialog"';
        modal += 'aria-labelledby="myModalLabel" aria-hidden="true">';
        modal += '<div class="modal-dialog"><div class="modal-content">';
        modal += '<div class="modal-body"></div></div></div></div>';
        $('body').append(modal);

      }
      function showHideControls(){
    		var total = $(getCurrentUl()+' li[data-bsp-li-index]').length;

    		if(total === clicked.nextImg){
    			$('a.next').hide();
    		}else{
    			$('a.next').show()
    		}
    		if(clicked.prevImg === -1){
    			$('a.previous').hide();
    		}else{
    			$('a.previous').show()
    		}
    	}
      function showModal(){

          var src = $(this).find('img').attr('src');
          var largeImg = $(this).find('img').attr('data-bsp-large-src');
          if(typeof largeImg === 'string'){
                src = largeImg;
          }
          var index = $(this).attr('data-bsp-li-index');
          var ulIndex = $(this).parent('ul').attr('data-bsp-ul-index');
          var ulId = $(this).parent('ul').attr('data-bsp-ul-id');

          clicked.img = src;
          clicked.prevImg = parseInt(index) - parseInt(1);
      		clicked.nextImg = parseInt(index) + parseInt(1);
          clicked.ulIndex = ulIndex;
          clicked.ulId = ulId;


          $('#bsPhotoGalleryModal').modal();

          var html = '';
          var img = '<img src="' + clicked.img + '" class="img-responsive"/>';

          html += img;
          html += '<span class="fa fa-times-circle-o clickable" data-dismiss="modal" style="position: absolute; right: -19px; top: -22px; font-size: 45px; color:#fff; text-shadow: 1px 1px 18px #000;"></span>';
          html += '<div style="height:25px;clear:both;display:block;">';
          html += '<a class="controls next pull-right" data-bsp-id="'+clicked.ulId+'" href="'+ (clicked.nextImg) + '">next &raquo;</a>';
          html += '<a class="controls previous" data-bsp-id="'+clicked.ulId+'" href="' + (clicked.prevImg) + '">&laquo; prev</a>';
          html += '</div>';
          $('#bsPhotoGalleryModal .modal-body').html(html);
          $('.glyphicon-remove-circle').on('click', closeModal);
          showHideControls();
      }

      function closeModal(){
        $('#bsPhotoGalleryModal').modal('hide');
      }

      function nextPrevHandler(){

          var ul = $(getCurrentUl());
          var index = $(this).attr('href');

          var src = ul.find('li[data-bsp-li-index="'+index+'"] img').attr('src');
          var largeImg = ul.find('li[data-bsp-li-index="'+index+'"] img').attr('data-bsp-large-src');
          if(typeof largeImg === 'string'){
                src = largeImg;
          }
          $('.modal-body img').attr('src', src);

          clicked.prevImg = parseInt(index) - 1;
          clicked.nextImg = parseInt(clicked.prevImg) + 2;

          if($(this).hasClass('previous')){
              $(this).attr('href', clicked.prevImg);
              $('a.next').attr('href', clicked.nextImg);
          }else{
              $(this).attr('href', clicked.nextImg);
              $('a.previous').attr('href', clicked.prevImg);
          }
          // console.log(clicked);
        showHideControls();
        return false;
      }
      function clearModalContent(){
        $('#bsPhotoGalleryModal .modal-body').html('');
        clicked = {};
      }
      function insertClearFix(el,x){
        var index = (x+1);
        $.each(classesArray,function(e){
           switch(classesArray[e]){
             //large
             case "col-lg-1":
                  if($(el).next('li.clearfix').length == 0){
                    $(el).after('<li class="clearfix visible-lg-block"></li>');
                  }
              break;
             case "col-lg-2":
                if(index%6 === 0){
                  $(el).after('<li class="clearfix visible-lg-block"></li>');
                }
              break;
             case "col-lg-3":
              if(index%4 === 0){
                $(el).after('<li class="clearfix visible-lg-block"></li>');
              }
             break;
             case "col-lg-4":
              if(index%3 === 0){
                $(el).after('<li class="clearfix visible-lg-block"></li>');
              }
             break;
             case "col-lg-5":
             case "col-lg-6":
              if(index%2 === 0){
                $(el).after('<li class="clearfix visible-lg-block"></li>');
              }
             break;
             //medium
             case "col-md-1":
                  if($(el).next('li.clearfix').length == 0){
                    $(el).after('<li class="clearfix visible-md-block"></li>');
                  }
              break;
             case "col-md-2":
                if(index%6 === 0){
                  $(el).after('<li class="clearfix visible-md-block"></li>');
                }
              break;
             case "col-md-3":
              if(index%4 === 0){
                $(el).after('<li class="clearfix visible-md-block"></li>');
              }
             break;
             case "col-md-4":
              if(index%3 === 0){
                $(el).after('<li class="clearfix visible-md-block"></li>');
              }
             break;
             case "col-md-5":
             case "col-md-6":
              if(index%2 === 0){
                $(el).after('<li class="clearfix visible-md-block"></li>');
              }
             break;
             //small
             case "col-sm-1":
                  if($(el).next('li.clearfix').length == 0){
                    $(el).after('<li class="clearfix visible-sm-block"></li>');
                  }
              break;
             case "col-sm-2":
                if(index%6 === 0){
                  $(el).after('<li class="clearfix visible-sm-block"></li>');
                }
              break;
             case "col-sm-3":
              if(index%4 === 0){
                $(el).after('<li class="clearfix visible-sm-block"></li>');
              }
             break;
             case "col-sm-4":
              if(index%3 === 0){
                $(el).after('<li class="clearfix visible-sm-block"></li>');
              }
             break;
             case "col-sm-5":
             case "col-sm-6":
              if(index%2 === 0){
                $(el).after('<li class="clearfix visible-sm-block"></li>');
              }
             break;
             //x-small
             case "col-xs-1":
                  if($(el).next('li.clearfix').length == 0){
                    $(el).after('<li class="clearfix visible-xs-block"></li>');
                  }
              break;
             case "col-xs-2":
                if(index%6 === 0){
                  $(el).after('<li class="clearfix visible-xs-block"></li>');
                }
              break;
             case "col-xs-3":
              if(index%4 === 0){
                $(el).after('<li class="clearfix visible-xs-block"></li>');
              }
             break;
             case "col-xs-4":
              if(index%3 === 0){
                $(el).after('<li class="clearfix visible-xs-block"></li>');
              }
             break;
             case "col-xs-5":
             case "col-xs-6":
              if(index%2 === 0){
                $(el).after('<li class="clearfix visible-xs-block"></li>');
              }
             break;
           }
        });
      }


      this.each(function(i){
        //ul
        var items = $(this).find('li');
        $(this).attr('data-bsp-ul-id', id);
        $(this).attr('data-bsp-ul-index', i);

        items.each(function(x){
          insertClearFix(this,x);
          $(this).addClass(classesString);
          $(this).attr('data-bsp-li-index', x);
          $(this).find('img').addClass('img-responsive');
          if(settings.hasModal === true){
            $(this).addClass('bspHasModal');
            $(this).on('click', showModal);
          }
        });
      })

      if(settings.hasModal === true){
        //this is for the next / previous buttons
        $(document).on('click', 'a.controls[data-bsp-id="'+id+'"]', nextPrevHandler);
        $(document).on('hidden.bs.modal', '#bsPhotoGalleryModal', clearModalContent);
        //start init methods
        createModalWrap();
      }

      return this;
  };
  /*defaults*/
  $.fn.bsPhotoGallery.defaults = {
    'classes' : 'col-lg-2 col-md-2 col-sm-3 col-xs-4',
    'hasModal' : true
  }


}(jQuery));
