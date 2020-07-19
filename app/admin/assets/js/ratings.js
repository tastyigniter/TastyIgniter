$(function () {
    $('[data-control="ratings"]').on('click', function (event) {
        var html,
            $el = $(event.currentTarget),
            table_row = $el.data('tableRow'),
            confirmMessage = $el.data('confirmMessage')

        html = '<tr id="table-row' + table_row + '">'
        html += '	<td class="list-action text-center handle"><i class="fa fa-arrows-alt-v"></i></td>'
        html += '	<td class="list-action handle"><a role="button" class="btn btn-outline-danger" onclick="confirm(\''+confirmMessage+'\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>'
        html += '	<td><input type="text" name="ratings[' + table_row + ']" class="form-control" value="" /></td>'
        html += '</tr>'

        $('#ratings-field tbody').append(html)

        table_row++
        $el.data('data-table-row', table_row)
    })

    Sortable.create($('#ratings-field tbody').get(0), {
        handle: '.handle',
    })
})