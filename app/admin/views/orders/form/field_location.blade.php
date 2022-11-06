<div class="py-2">
    <p class="lead">{{ $formModel->location->location_name }}</p>
    {{ format_address($formModel->location->getAddress()) }}
</div>
