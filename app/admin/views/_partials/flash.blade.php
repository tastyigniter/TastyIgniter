@foreach(Flash::all() as $message)
    @if($message['overlay'])
        <div
            data-control="flash-overlay"
            data-title="{{ array_get($message, 'title') }}"
            data-text="{!! array_get($message, 'message') !!}"
            data-icon="{{ $message['level'] }}"
            data-close-on-click-outside="{{ $message['important'] ? 'false' : 'true' }}"
            data-close-on-esc="{{ $message['important'] ? 'false' : 'true' }}"
        ></div>
    @else
        <div
            @class(['alert alert-'.$message['level'], 'alert-important' => $message['important']])
            data-control="flash-message"
            data-allow-dismiss="{{ $message['important'] ? 'false' : 'true' }}"
            role="alert"
        >{!! $message['message'] !!}</div>
    @endif
@endforeach
@if($messages = session('admin_errors', collect())->all())
    <div
        class="alert alert-danger"
        data-control="flash-message"
        data-allow-dismiss="false"
        role="alert"
    >
        @foreach($messages as $message)
            <p>{!! $message !!}</p>
        @endforeach
    </div>
    @php
        session()->forget('admin_errors')
    @endphp
@endif
