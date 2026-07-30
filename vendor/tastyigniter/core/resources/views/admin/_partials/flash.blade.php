@foreach(Flash::all() as $message)
    @if($message['overlay'])
        <div
            data-control="flash-overlay"
            data-title="{{ array_get($message, 'title') }}"
            data-html="{{html(array_get($message, 'message'))}}"
            data-level="{{ $message['level'] }}"
            data-close-on-click-outside="{{ $message['important'] ? 'false' : 'true' }}"
            data-close-on-esc="{{ $message['important'] ? 'false' : 'true' }}"
        ></div>
    @else
        <div
            @class(['alert alert-'.$message['level'], 'alert-important' => $message['important']])
            data-control="flash-message"
            data-level="{{ $message['level'] }}"
            data-html="{{html(array_get($message, 'message'))}}"
            data-allow-dismiss="{{ $message['important'] ? 'false' : 'true' }}"
            role="alert"
        ></div>
    @endif
@endforeach
@if($messages = session()->pull('admin_errors'))
    <div
        class="alert alert-danger"
        data-control="flash-message"
        data-level="danger"
        data-html="{{html(implode('<br>', array_collapse($messages)))}}"
        data-allow-dismiss="false"
        role="alert"
    ></div>
@endif
