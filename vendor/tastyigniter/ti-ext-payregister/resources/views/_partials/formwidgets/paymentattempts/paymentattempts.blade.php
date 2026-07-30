<div
    id="{{ $this->getId() }}"
    class="paymentattempts-widget"
    data-control="payment-attempts"
    data-alias="{{ $this->alias }}"
>
    {!! $dataTableWidget->render() !!}
</div>
