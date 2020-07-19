<?php

namespace Admin\Traits;

use Carbon\Carbon;

trait HasInvoice
{
    public static function bootHasInvoice()
    {
        self::extend(function (self $model) {
            $model->casts = array_merge($model->casts, ['invoice_date' => 'dateTime']);
        });

        static::saved(function (self $model) {
            if ($model->isPaymentProcessed() AND !$model->hasInvoice())
                $model->generateInvoice();
        });
    }

    public function getInvoiceNumberAttribute()
    {
        if (!strlen($this->invoice_prefix))
            return null;

        return $this->invoice_prefix.$this->order_id;
    }

    public function getInvoiceNoAttribute()
    {
        if (!strlen($this->invoice_prefix))
            return null;

        return $this->invoice_prefix.$this->order_id;
    }

    public function hasInvoice()
    {
        return !empty($this->invoice_date);
    }

    public function generateInvoice()
    {
        if ($this->hasInvoice())
            return $this->invoice_number;

        $invoiceDate = is_null($this->invoice_date)
            ? Carbon::now() : $this->invoice_date;

        $invoicePrefix = is_null($this->invoice_prefix)
            ? $this->generateInvoicePrefix($invoiceDate)
            : $this->invoice_prefix;

        $this->newQuery()->where($this->getKeyName(), $this->getKey())->update([
            'invoice_date' => $invoiceDate,
            'invoice_prefix' => $invoicePrefix,
        ]);

        return $this->invoice_number;
    }

    public function generateInvoicePrefix($invoiceDate = null)
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