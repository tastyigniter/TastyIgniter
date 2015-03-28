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

function confirmOrder() {
	document.getElementById("checkout-form").submit();
	document.getElementById("delivery-form").submit();
	document.getElementById("payment-form").submit();
}

function reserveTable() {
	document.getElementById("reserve-form").submit();
}