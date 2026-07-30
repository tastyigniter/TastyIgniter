<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Concerns;

use Igniter\System\Models\Settings;
use Illuminate\Support\Carbon;

trait HasInvoice
{
    public static function bootHasInvoice(): void
    {
        self::extend(function(self $model): void {
            $model->addCasts(['invoice_date' => 'datetime']);
        });

        static::saved(function(self $model): void {
            if ($model->isPaymentProcessed() && !$model->hasInvoice()) {
                $model->generateInvoice();
            }
        });
    }

    public function getInvoiceNumberAttribute()
    {
        return $this->getInvoiceNoAttribute();
    }

    public function getInvoiceNoAttribute(): ?string
    {
        if ((string)$this->invoice_prefix === '') {
            return null;
        }

        return $this->invoice_prefix.$this->order_id;
    }

    public function hasInvoice(): bool
    {
        return !empty($this->invoice_date) && !empty($this->invoice_prefix);
    }

    public function generateInvoice()
    {
        if ($this->hasInvoice()) {
            return $this->invoice_number;
        }

        $invoiceDate = $this->invoice_date ?? Carbon::now();

        $invoicePrefix = $this->invoice_prefix ?? $this->generateInvoicePrefix($invoiceDate);

        $this->invoice_date = $invoiceDate;
        $this->invoice_prefix = $invoicePrefix;
        $this->saveQuietly();

        return $this->invoice_number;
    }

    public function generateInvoicePrefix($invoiceDate = null): string
    {
        $invoiceDate ??= $this->invoice_date;

        return parse_values([
            'year' => $invoiceDate->year,
            'month' => $invoiceDate->month,
            'day' => $invoiceDate->day,
            'hour' => $invoiceDate->hour,
            'minute' => $invoiceDate->minute,
            'second' => $invoiceDate->second,
        ], Settings::get('invoice_prefix', 'INV-{year}-00'));
    }
}
