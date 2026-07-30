<?php

namespace Mollie\Api\Types;

class PaymentMethod
{
    /**
     * @link https://www.mollie.com/en/payments/alma
     */
    public const ALMA = "alma";

    /**
     * @link https://www.mollie.com/en/payments/applepay
     */
    public const APPLEPAY = "applepay";

    /**
     * @link https://www.mollie.com/en/payments/bacs
     */
    public const BACS = "bacs";

    /**
     * @link https://www.mollie.com/en/payments/bancomatpay
     */
    public const BANCOMATPAY = "bancomatpay";

    /**
     * @link https://www.mollie.com/en/payments/bancontact
     */
    public const BANCONTACT = "bancontact";

    /**
     * @link https://www.mollie.com/en/payments/bank-transfer
     */
    public const BANKTRANSFER = "banktransfer";

    /**
     * @link https://www.mollie.com/en/payments/belfius
     */
    public const BELFIUS = "belfius";

    /**
     * @link https://www.mollie.com/en/payments/billie
     */
    public const BILLIE = "billie";

    /**
     * @deprecated 2019-05-01
     */
    public const BITCOIN = "bitcoin";

    /**
     * @link https://www.mollie.com/en/payments/blik
     */
    public const BLIK = "blik";

    /**
     * @link https://www.mollie.com/en/payments/credit-card
     */
    public const CREDITCARD = "creditcard";

    /**
     * @link https://www.mollie.com/en/payments/direct-debit
     */
    public const DIRECTDEBIT = "directdebit";

    /**
     * @link https://www.mollie.com/en/payments/eps
     */
    public const EPS = "eps";

    /**
     * @link https://www.mollie.com/en/payments/gift-cards
     */
    public const GIFTCARD = "giftcard";

    /**
     * @deprecated
     * @link https://www.mollie.com/en/payments/giropay
     */
    public const GIROPAY = "giropay";

    /**
     * @link https://www.mollie.com/en/payments/in3
     */
    public const IN3 = "in3";

    /**
     * @link https://www.mollie.com/en/payments/ideal
     */
    public const IDEAL = "ideal";

    /**
     * Support for inghomepay will be discontinued February 1st, 2021.
     * Make sure to remove this payment method from your checkout if needed.
     *
     * @deprecated
     * @link https://docs.mollie.com/changelog/v2/changelog
     *
     */
    public const INGHOMEPAY = "inghomepay";

    /**
     * @link https://www.mollie.com/en/payments/kbc-cbc
     */
    public const KBC = "kbc";

    public const KLARNA_ONE = "klarna";

    /**
     * @link https://www.mollie.com/en/payments/klarna-pay-later
     */
    public const KLARNA_PAY_LATER = "klarnapaylater";

    /**
     * @link https://www.mollie.com/en/payments/klarna-pay-now
     */
    public const KLARNA_PAY_NOW = "klarnapaynow";

    /**
     * @link https://www.mollie.com/en/payments/klarna-slice-it
     */
    public const KLARNA_SLICE_IT = "klarnasliceit";

    /**
     * @link https://www.mollie.com/en/payments/mb-way
     */
    public const MBWAY = "mbway";

    /**
     * @link https://www.mollie.com/en/payments/multibanco
     */
    public const MULTIBANCO = "multibanco";

    /**
     * @link https://www.mollie.com/en/payments/mybank
     */
    public const MYBANK = "mybank";

    /**
     * @link https://www.mollie.com/en/payments/payconiq
     */
    public const PAYCONIQ = "payconiq";

    /**
     * @link https://www.mollie.com/en/payments/paypal
     */
    public const PAYPAL = "paypal";

    /**
     * @link https://www.mollie.com/en/payments/paysafecard
     */
    public const PAYSAFECARD = "paysafecard";

    /**
     * @link https://www.mollie.com/en/payments/pay-by-bank
     */
    public const PAYBYBANK = "paybybank";

    /**
     * @deprecated
     * @link https://www.mollie.com/en/payments/gift-cards
     */
    public const PODIUMCADEAUKAART = "podiumcadeaukaart";

    /**
     * @link https://docs.mollie.com/point-of-sale/overview
     */
    public const POINT_OF_SALE = "pointofsale";

    /**
     * @link https://www.mollie.com/en/payments/przelewy24
     */
    public const PRZELEWY24 = 'przelewy24';

    /**
     * @link https://www.mollie.com/en/payments/satispay
     */
    public const SATISPAY = "satispay";
    
    /**
     * @link https://www.mollie.com/en/payments/sofort
     */
    public const SOFORT = "sofort";

    /**
     * @link https://www.mollie.com/en/payments/riverty
     */
    public const RIVERTY = "riverty";

    /**
     * @link https://www.mollie.com/en/payments/trustly
     */
    public const TRUSTLY = "trustly";

    /**
     * @link https://www.mollie.com/en/payments/twint
     */
    public const TWINT = "twint";
}
