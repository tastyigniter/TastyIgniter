$(function() {
    $('#side-menu').metisMenu();
});


//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    $(document).on('click', '.sidebar-toggle', function() {
        if ($('#wrapper > .navbar').hasClass('hide-menu')) {
            $('#wrapper > .navbar').removeClass('hide-menu');
            $("#page-wrapper, #footer").css("margin-left", "220px");
        } else {
            $('#wrapper > .navbar').addClass('hide-menu');
            $("#page-wrapper, #footer").css("margin-left", "46px");
        }
    })
})

function mediaManager(field) {
    var height = (this.window.innerHeight > 0) ? this.window.innerHeight-100 : this.screen.height-100;
    $(window).bind("load resize", function() {
        var height = (this.window.innerHeight > 0) ? this.window.innerHeight-100 : this.screen.height-100;
        $('#media-manager > iframe').css("height", (height) + "px");
    });

    $('#media-manager').remove();

    var iframe_url = js_site_url('image_manager?popup=iframe&field_id=') + encodeURIComponent(field) + '&sub_folder=' + $('#' + field).attr('value');

    $('body').append('<div id="media-manager"><iframe src="'+ iframe_url +'" width="1200" height="' + height + 'px" frameborder="0"></iframe></div>');

    $.fancybox({
        padding : 0,
        title: "Media Manager",
        helpers : {
            title: {
                type: 'inside',
                position: 'top'
            }
        },
        href:"#media-manager",
        autoResize: true,
        scrolling: 'no',
        preload   : true,
        afterClose: function() {
            if ($('#' + field).attr('value')) {
                $.ajax({
                    url: js_site_url('image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')) + '&width=120&height=120',
                    dataType: 'json',
                    success: function(json) {
                        var thumb = $('#' + field).parent().parent().find('.thumb');
                        $(thumb).attr('src', json);
                    }
                });
            }
        }
    });
};

function imageManager(field, url, type, win) {
	var iframe_url = js_site_url('image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	tinyMCE.activeEditor.windowManager.open({
		file : iframe_url,
		title : 'Image Manager',
		width : 980,
		height : 550,
		resizable : 'yes',
		inline : 'yes',
		close_previous : 'no'
	}, {
		window : win,
		input : field,
		updateInput: function (url) {
			var fieldElm = win.document.getElementById(field);
			fieldElm.value = url;

			if ("fireEvent" in fieldElm) {
				fieldElm.fireEvent("onchange")
			} else {
				var evt = document.createEvent("HTMLEvents");
				evt.initEvent("change", false, true);
				fieldElm.dispatchEvent(evt);
			}
		}
	});

	return false;
}

$(function(){
	$('#page-wrapper').on('click', '.panel-table .btn-filter', function(e) {
		var $this = $(this),
		$panel = $this.parents('.panel'),
        $panelFilter = $panel.find('.panel-filter');

        $panel.find('.panel-filter').slideToggle(function() {
            if ($panelFilter.is(':visible')) {
                $('.panel-table .btn-filter').addClass('active');
            } else {
                $('.panel-table .btn-filter').removeClass('active');
            }
        });
	});

    //$('#page-wrapper .panel-table .btn-filter').trigger('click');

    $('.dropdown-messages .menu-body').load(js_site_url('messages/latest'));
    $('.dropdown-activities .menu-body').load(js_site_url('activities/latest'));
})


$(function() {
    var alertMsgs = $('.alert-collapsible .alert-hide');
    var dropdownButton = $('.btn-dropdown');
    alertMsgs.hide();

    //Click dropdown
    dropdownButton.click(function() {
        //current button
        var currentButton = $(this);
        alertMsgs.slideToggle(400, function() {
            //Completed slidetoggle
            if(alertMsgs.is(':visible')) {
                currentButton.html('<i class="fa fa-chevron-up text-muted"></i>');
            } else {
                currentButton.html('<i class="fa fa-chevron-down text-muted"></i>');
            }
        })
    });
})

$(function() {
    window.setInterval(function () {
        //updateNotifications();
    }, 60000);

	function updateNotifications() {
		$.ajax({
			url: js_site_url('cart_module/cart_module/add'),
			type: 'POST',
			//data: data,
			dataType: 'json',
			success: function(json) {
			}
		});

		//setTimeout('updateNotifications()', 15000); // Every 15 seconds.
	}

});
