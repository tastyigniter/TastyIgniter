<?php

declare(strict_types=1);

namespace Square\Models;

class CheckoutOptionsPaymentType
{
    /**
     * Accept credit card or debit card payments via tap, dip or swipe.
     */
    public const CARD_PRESENT = 'CARD_PRESENT';

    /**
     * Launches the manual credit or debit card entry screen for the buyer to complete.
     */
    public const MANUAL_CARD_ENTRY = 'MANUAL_CARD_ENTRY';

    /**
     * Launches the iD checkout screen for the buyer to complete.
     */
    public const FELICA_ID = 'FELICA_ID';

    /**
     * Launches the QUICPay checkout screen for the buyer to complete.
     */
    public const FELICA_QUICPAY = 'FELICA_QUICPAY';

    /**
     * Launches the Transportation Group checkout screen for the buyer to complete.
     */
    public const FELICA_TRANSPORTATION_GROUP = 'FELICA_TRANSPORTATION_GROUP';

    /**
     * Launches a checkout screen for the buyer on the Square Terminal that
     * allows them to select a specific FeliCa brand or select the check balance screen.
     */
    public const FELICA_ALL = 'FELICA_ALL';

    /**
     * Launches the PayPay checkout screen for the buyer to complete.
     */
    public const PAYPAY = 'PAYPAY';
}
