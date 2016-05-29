$.fn.tabs = function() {
	var selector = this;

	this.each(function() {
		var obj = $(this);

		$(obj.attr('rel')).hide();

		$(obj).click(function() {
			$(selector).removeClass('active');

			$(selector).each(function(i, element) {
				$($(element).attr('rel')).hide();
			});

			$(this).addClass('active');

			$($(this).attr('rel')).show();

			return false;
		});
	});

	$(this).show();

	$(this).first().click();
};

$(function() {
    var alertMsgs = $('.alert-collapsible .alert-hide');
    var dropdownButton = $('.btn-dropdown');
    alertMsgs.hide();

    //Click dropdown
    dropdownButton.click(function() {
        //get data-for attribute
        //var dataFor = $(this).attr('data-for');
        //var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        alertMsgs.slideToggle(function() {
            //Completed slidetoggle
            if(alertMsgs.is(':visible')) {
                currentButton.html('<i class="fa fa-chevron-up text-muted"></i>');
            } else {
                currentButton.html('<i class="fa fa-chevron-down text-muted"></i>');
            }
        })
    });
});

$(function () {

    $(document).on('change', '.btn-group-toggle input[type="radio"], .btn-group input[type="radio"]', function() {
        var btn = $(this).parent();
        var parent = btn.parent();
        var activeClass = (btn.attr('data-btn')) ? btn.attr('data-btn'): 'btn-default';

        parent.find('.btn').each(function() {
            removeClass = ($(this).attr('data-btn')) ? $(this).attr('data-btn') : activeClass;
            $(this).removeClass(removeClass);
        });

        btn.addClass(activeClass);
    });

    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'fa fa-check-square-o'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
            }
        }
        init();
    });
});

function displayRatings(ratings) {
    $('.rating-star').raty({
        score: function () {
            return $(this).attr('data-score');
        },
        scoreName: function () {
            return $(this).attr('data-score-name');
        },
        readOnly: function () {
            return $(this).attr('data-readonly') == 'true';
        },
        hints: ratings,
        starOff: 'fa fa-star-o',
        starOn: 'fa fa-star',
        cancel: false, half: false, starType: 'i'
    });

    $('.rating-star i[title]').tooltip({placement: 'bottom'});
}

$(function () {
    $(window).bind("load resize", function() {
        $('.affix-module').each(function() {
            $(this).find('[data-spy="affix"]:first-child').css('width', $(this).width());
        });
    });
});