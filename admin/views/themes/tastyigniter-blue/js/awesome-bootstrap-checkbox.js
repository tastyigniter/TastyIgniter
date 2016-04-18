$(function() {
    $('input[type="checkbox"], input[type="radio"]').each(function() {

        if (!$(this).parent('label, .button-checkbox').length) {
            var checkboxDiv = $('<div/>').addClass('checkbox');
            var checkboxLabel = $('<label/>');

            $(this).before(checkboxLabel);
            $(this).before(checkboxDiv);
            checkboxDiv.append(this).append(checkboxLabel);
        }
    });
});