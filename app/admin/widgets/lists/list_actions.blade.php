@if($bulkActions)
    <tr
        class="bulk-actions hide"
        data-control="bulk-actions"
        data-action-total-records="{{ $records->total() }}"
    >
        <td class="bulk-action pb-0 ">
            <div class="form-check active">
                <input
                    type="checkbox" id="{{ 'checkboxAll-bulk-'.$listId }}"
                    class="form-check-input" onclick="$('input[name*=\'checked\']').prop('checked', this.checked)"/>
                <label class="form-check-label" for="{{ 'checkboxAll-bulk-'.$listId }}">&nbsp;</label>
            </div>
        </td>
        <td class="w-100 pb-0 pt-1" colspan="999">
            <div>
                <div class="btn-counter btn py-1 text-nowrap">
                    <span data-action-counter>0</span> record(s) selected
                </div>
                <a
                    role="button"
                    class="py-1 pl-0 btn-select-all btn btn-link hide"
                    data-control="check-total-records"
                >{{ sprintf(lang('admin::lang.list.actions.text_select_all'), $records->total()) }}</a>
                <input type="hidden" data-action-select-all name="select_all" value="1" disabled="disabled">
                &nbsp;
                @foreach($bulkActions as $actionCode => $bulkAction)
                    {!! $this->renderBulkActionButton($bulkAction->getActionButton()) !!}
                @endforeach
            </div>
            <div id="{{$this->getId('bulk-action-modal-container')}}"></div>
        </td>
    </tr>
@endif
