<div>
    @if(count($reservations))
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                <tr>
                    <th>@lang('igniter.reservation::default.column_id')</th>
                    <th>@lang('igniter.reservation::default.column_location')</th>
                    <th>@lang('igniter.reservation::default.column_status')</th>
                    <th>@lang('igniter.reservation::default.column_date')</th>
                    <th>@lang('igniter.reservation::default.column_table')</th>
                    <th>@lang('igniter.reservation::default.column_guest')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reservations as $reservation)
                    <tr @class(['align-middle', 'border-top' => !$loop->first])>
                        <td>
                            <a
                                class="btn btn-light"
                                href="{{ page_url($reservationPage, ['reservationId' => $reservation->reservation_id, 'hash' => $reservation->hash]) }}"
                            >#{{ $reservation->reservation_id }}</a>
                        </td>
                        <td>{{ $reservation->location ? $reservation->location->location_name : null }}</td>
                        <td><b>{{ $reservation->status?->status_name }}</b></td>
                        <td>{{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}</td>
                        <td>{{ $reservation->table_name }}</td>
                        <td>{{ $reservation->guest_num }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-bar text-right">
            <div class="links">{!! $reservations->links() !!}</div>
        </div>
    @else
        <p>@lang('igniter.reservation::default.text_empty')</p>
    @endif
</div>
