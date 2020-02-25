<?php

namespace Admin\Traits;

use Carbon\Carbon;

trait HasInvoice
{
    public static function bootHasInvoice()
    {
        static::saved(function (self $model) {
            if ($model->isPaymentProcessed() AND !$model->hasInvoice())
                $model->generateInvoice();
        });
    }

    public function getInvoiceIdAttribute()
    {
        return $this->getInvoiceNoAttribute();
    }

    public function getInvoiceNoAttribute()
    {
        if (!strlen($this->invoice_prefix))
            return null;

        return $this->invoice_prefix.$this->order_id;
    }

    public function hasInvoice()
    {
        return !empty($this->invoice_date) AND strlen($this->invoice_prefix);
    }

    public function generateInvoice()
    {
        if ($this->hasInvoice())
            return $this->invoice_no;

        $invoiceDate = Carbon::now();
        if (is_null($this->invoice_date))
            $this->invoice_date = $invoiceDate;

        if (is_null($this->invoice_prefix))
            $this->invoice_prefix = $this->invoiceGeneratePrefix($invoiceDate);

        self::withoutEvents(function () {
            $this->timestamps = FALSE;
            $this->save();
            $this->timestamps = TRUE;
        });

        return $this->invoice_no;
    }

    public function invoiceGeneratePrefix($invoiceDate = null)
    {
        $invoiceDate = $invoiceDate ?? $this->invoice_date;

        return parse_values([
            'year' => $invoiceDate->year,
            'month' => $invoiceDate->month,
            'day' => $invoiceDate->day,
            'hour' => $invoiceDate->hour,
            'minute' => $invoiceDate->minute,
            'second' => $invoiceDate->second,
        ], setting('invoice_prefix') ?: 'INV-{year}-00');
    }
}