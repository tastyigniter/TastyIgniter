@if($bulkActions)
    <tr
        class="bulk-actions hide"
        data-control="bulk-actions"
        data-action-total-records="{{ $records->count() }}"
    >
        <th class="bg-warning-subtle" colspan="999">
            <div>
                <div class="btn-counter btn fw-normal py-1 text-nowrap shadow-none pe-none">
                    <span data-action-counter>0</span> record(s) selected
                </div>
                <a
                  role="button"
                  class="py-1 pl-0 btn-select-all btn btn-link hide"
                  data-control="check-total-records"
                >{{ sprintf(lang('igniter::admin.list.actions.text_select_all'), $records->count()) }}</a>
                <input type="hidden" data-action-select-all name="select_all" value="1" disabled="disabled">
                &nbsp;
                @foreach($bulkActions as $actionCode => $bulkAction)
                    {!! $this->renderBulkActionButton($bulkAction->getActionButton()) !!}
                @endforeach
            </div>
            <div id="{{$this->getId('bulk-action-modal-container')}}"></div>
        </th>
    </tr>
@endif
