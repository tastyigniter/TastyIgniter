<div class="row-fluid">
    {!! form_open(current_url(),
        [
            'id'     => 'list-form',
            'role'   => 'form',
            'method' => 'POST',
        ]
    ) !!}

    {!! $this->widgets['toolbar']->render() !!}

    <div class="list-table table-responsive">
        <table class="table table-hover border-bottom">
            <thead>
            <tr>
                <th width="10%">Level</th>
                <th width="15%">Date</th>
                <th>Content</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $key => $log)
                <tr>
                    <td class="text-{{ $log['class'] }}">
                        <span
                            class="fa fa-{{ $log['icon'] }}"
                            aria-hidden="true"
                        ></span>&nbsp;&nbsp;{{ $log['level'] }}
                    </td>
                    <td class="date">{{ date('Y-m-d H:i:s', strtotime($log['date'])) }}</td>
                    <td
                        class="text"
                        @if ($log['stack'])
                        role="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#stack-{{ $key }}"
                        aria-expanded="false"
                        aria-controls="stack{{ $key }}"
                        @endif
                    >
                        {{ $log['text'] }}

                        @isset($log['summary'])
                            <br/> {{ $log['summary'] }}
                        @endisset

                        @if ($log['stack'])
                            <div class="collapse" id="stack-{{ $key }}">
                                {!! nl2br(trim(e($log['stack']))) !!}
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! form_close() !!}
</div>
