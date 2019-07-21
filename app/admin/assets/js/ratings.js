$(function () {
    $('[data-control="ratings"]').on('click', function (el) {
        var html, table_row = $(el).data('data-table-row')

        html = '<tr id="table-row' + table_row + '">'
        html += '	<td class="list-action text-center handle"><i class="fa fa-bars"></i></td>'
        html += '	<td class="list-action handle"><a role="button" class="btn btn-outline-danger" onclick="confirm($(el).data(\'data-confirm-message\')) ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>'
        html += '	<td><input type="text" name="ratings[' + table_row + ']" class="form-control" value="" /></td>'
        html += '</tr>'

        $('#ratings-field .table-sortable tbody').append(html)

        table_row++
        $(el).data('data-table-row', table_row)
    })

    $('#ratings-field .table-sortable').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        placeholder: '<tr class="placeholder"><td colspan="99"></td></tr>',
        handle: '.handle'
    })
})