<div
    data-control="status-workflow"
    data-modal-selector="#status-workflow-modal-{id}"
    data-action-url="{{ admin_url('igniter/cart/status_workflows/{action}/{id}') }}"
    data-locations='@json($locations)'
>
    <script type="text/template" data-status-workflow-modal-template>
        <div class="modal fade" id="status-workflow-modal-{id}" tabindex="-1" role="dialog" data-order-id="{id}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{locationName}: #{id}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="modal-title mb-3">{type} at {dateTime}</h5>
                        <p>{items}</p>
                        <p class="fw-bold mb-0">Total: {total}</p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-success"
                            data-status-workflow-control="accept"
                        >
                            <i class="fa fa-check mr-1" aria-hidden="true"></i> Accept
                        </button>
                        @if($delayTimes)
                            <div class="dropdown">
                                <button
                                    type="button"
                                    class="btn btn-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                >
                                    <i class="fa fa-clock mr-1" aria-hidden="true"></i> <span class="mr-1">Accept & Delay</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach($delayTimes as $delayTime)
                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            data-status-workflow-control="delay"
                                            data-delay-minutes="{{$delayTime}}"
                                        >{{$delayTime}} minutes</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="dropdown">
                            <button
                                type="button"
                                class="btn btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown"
                            ><i class="fa fa-ban mr-1" aria-hidden="true"></i> Decline
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($rejectCodes as $rejectCode)
                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-status-workflow-control="reject"
                                        data-reason-code="{{$rejectCode}}"
                                    >{{$rejectCode}}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>
</div>
