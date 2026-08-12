<div class="container-fluid">
    <h2>Floors & Tables</h2>
    <p>Use the JSON endpoints to create and update floors/tables. The Phase 1.8 editor intentionally uses simple coordinates, sizing, shape and sort-order fields instead of unsafe drag-and-drop.</p>
    <h3>Floors</h3>
    <table class="table table-striped"><thead><tr><th>Name</th><th>Code</th><th>Active</th></tr></thead><tbody>@foreach($floors as $floor)<tr><td>{{ $floor->name }}</td><td>{{ $floor->code }}</td><td>{{ $floor->is_active ? 'Yes' : 'No' }}</td></tr>@endforeach</tbody></table>
    <h3>Tables</h3>
    <table class="table table-striped"><thead><tr><th>Floor</th><th>Table</th><th>Capacity</th><th>Status</th><th>Position</th></tr></thead><tbody>@foreach($tables as $table)<tr><td>{{ $table->floor->name ?? '' }}</td><td>{{ $table->name }} / {{ $table->code }}</td><td>{{ $table->capacity }}</td><td>{{ $table->status }}</td><td>{{ $table->position_x }}, {{ $table->position_y }} ({{ $table->width }}×{{ $table->height }})</td></tr>@endforeach</tbody></table>
</div>
