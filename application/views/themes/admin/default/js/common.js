function imageManager(field, url, type, win) {
	var iframe_url = js_site_url('admin/image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

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
