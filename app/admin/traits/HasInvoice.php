<?php

namespace Admin\Traits;

use Admin\Models\Orders_model;
use Carbon\Carbon;
use Event;

trait HasInvoice
{
    public static function bootHasInvoice()
    {
        Event::listen('admin.statusHistory.beforeAddStatus', function ($model, $object, $statusId, $previousStatus) {
            if (!$object instanceof Orders_model)
                return;

            if (!(bool)setting('auto_invoicing'))
                return;

            if (!in_array($statusId, setting('completed_order_status')))
                return;

            if (!method_exists($object, 'generateInvoice'))
                return;

            $object->generateInvoice();
        });
    }

    public function getInvoiceIdAttribute()
    {
        return $this->invoice_prefix.$this->invoice_no;
    }

    public function hasInvoice()
    {
        return $this->invoice_no > 0 AND is_numeric($this->invoice_no);
    }

    public function generateInvoice()
    {
        if ($this->hasInvoice())
            return $this->invoice_id;

        $this->invoiceSetDate(Carbon::now());

        $this->invoice_no = $this->invoiceGetNextNum();
        $this->invoice_prefix = $this->invoiceGetPrefix();
        $this->save();

        return $this->invoice_id;
    }

    protected function invoiceGetNextNum()
    {
        return static::on()->max('invoice_no') + 1;
    }

    protected function invoiceGetPrefix()
    {
        $now = $this->invoiceGetDate();

        return parse_values([
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->day,
            'hour' => $now->hour,
            'minute' => $now->minute,
            'second' => $now->second,
        ], setting('invoice_prefix') ?: 'INV-{year}-00');
    }

    protected function invoiceGetDate()
    {
        return $this->invoice_date;
    }

    protected function invoiceSetDate($date)
    {
        return $this->invoice_date = $date;
    }
}