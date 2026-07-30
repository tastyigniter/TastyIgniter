<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the associated currency for an amount of money. Values correspond
 * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
 */
class Currency
{
    /**
     * Unknown currency
     */
    public const UNKNOWN_CURRENCY = 'UNKNOWN_CURRENCY';

    /**
     * United Arab Emirates dirham
     */
    public const AED = 'AED';

    /**
     * Afghan afghani
     */
    public const AFN = 'AFN';

    /**
     * Albanian lek
     */
    public const ALL = 'ALL';

    /**
     * Armenian dram
     */
    public const AMD = 'AMD';

    /**
     * Netherlands Antillean guilder
     */
    public const ANG = 'ANG';

    /**
     * Angolan kwanza
     */
    public const AOA = 'AOA';

    /**
     * Argentine peso
     */
    public const ARS = 'ARS';

    /**
     * Australian dollar
     */
    public const AUD = 'AUD';

    /**
     * Aruban florin
     */
    public const AWG = 'AWG';

    /**
     * Azerbaijani manat
     */
    public const AZN = 'AZN';

    /**
     * Bosnia and Herzegovina convertible mark
     */
    public const BAM = 'BAM';

    /**
     * Barbados dollar
     */
    public const BBD = 'BBD';

    /**
     * Bangladeshi taka
     */
    public const BDT = 'BDT';

    /**
     * Bulgarian lev
     */
    public const BGN = 'BGN';

    /**
     * Bahraini dinar
     */
    public const BHD = 'BHD';

    /**
     * Burundian franc
     */
    public const BIF = 'BIF';

    /**
     * Bermudian dollar
     */
    public const BMD = 'BMD';

    /**
     * Brunei dollar
     */
    public const BND = 'BND';

    /**
     * Boliviano
     */
    public const BOB = 'BOB';

    /**
     * Bolivian Mvdol
     */
    public const BOV = 'BOV';

    /**
     * Brazilian real
     */
    public const BRL = 'BRL';

    /**
     * Bahamian dollar
     */
    public const BSD = 'BSD';

    /**
     * Bhutanese ngultrum
     */
    public const BTN = 'BTN';

    /**
     * Botswana pula
     */
    public const BWP = 'BWP';

    /**
     * Belarusian ruble
     */
    public const BYR = 'BYR';

    /**
     * Belize dollar
     */
    public const BZD = 'BZD';

    /**
     * Canadian dollar
     */
    public const CAD = 'CAD';

    /**
     * Congolese franc
     */
    public const CDF = 'CDF';

    /**
     * WIR Euro
     */
    public const CHE = 'CHE';

    /**
     * Swiss franc
     */
    public const CHF = 'CHF';

    /**
     * WIR Franc
     */
    public const CHW = 'CHW';

    /**
     * Unidad de Fomento
     */
    public const CLF = 'CLF';

    /**
     * Chilean peso
     */
    public const CLP = 'CLP';

    /**
     * Chinese yuan
     */
    public const CNY = 'CNY';

    /**
     * Colombian peso
     */
    public const COP = 'COP';

    /**
     * Unidad de Valor Real
     */
    public const COU = 'COU';

    /**
     * Costa Rican colon
     */
    public const CRC = 'CRC';

    /**
     * Cuban convertible peso
     */
    public const CUC = 'CUC';

    /**
     * Cuban peso
     */
    public const CUP = 'CUP';

    /**
     * Cape Verdean escudo
     */
    public const CVE = 'CVE';

    /**
     * Czech koruna
     */
    public const CZK = 'CZK';

    /**
     * Djiboutian franc
     */
    public const DJF = 'DJF';

    /**
     * Danish krone
     */
    public const DKK = 'DKK';

    /**
     * Dominican peso
     */
    public const DOP = 'DOP';

    /**
     * Algerian dinar
     */
    public const DZD = 'DZD';

    /**
     * Egyptian pound
     */
    public const EGP = 'EGP';

    /**
     * Eritrean nakfa
     */
    public const ERN = 'ERN';

    /**
     * Ethiopian birr
     */
    public const ETB = 'ETB';

    /**
     * Euro
     */
    public const EUR = 'EUR';

    /**
     * Fiji dollar
     */
    public const FJD = 'FJD';

    /**
     * Falkland Islands pound
     */
    public const FKP = 'FKP';

    /**
     * Pound sterling
     */
    public const GBP = 'GBP';

    /**
     * Georgian lari
     */
    public const GEL = 'GEL';

    /**
     * Ghanaian cedi
     */
    public const GHS = 'GHS';

    /**
     * Gibraltar pound
     */
    public const GIP = 'GIP';

    /**
     * Gambian dalasi
     */
    public const GMD = 'GMD';

    /**
     * Guinean franc
     */
    public const GNF = 'GNF';

    /**
     * Guatemalan quetzal
     */
    public const GTQ = 'GTQ';

    /**
     * Guyanese dollar
     */
    public const GYD = 'GYD';

    /**
     * Hong Kong dollar
     */
    public const HKD = 'HKD';

    /**
     * Honduran lempira
     */
    public const HNL = 'HNL';

    /**
     * Croatian kuna
     */
    public const HRK = 'HRK';

    /**
     * Haitian gourde
     */
    public const HTG = 'HTG';

    /**
     * Hungarian forint
     */
    public const HUF = 'HUF';

    /**
     * Indonesian rupiah
     */
    public const IDR = 'IDR';

    /**
     * Israeli new shekel
     */
    public const ILS = 'ILS';

    /**
     * Indian rupee
     */
    public const INR = 'INR';

    /**
     * Iraqi dinar
     */
    public const IQD = 'IQD';

    /**
     * Iranian rial
     */
    public const IRR = 'IRR';

    /**
     * Icelandic króna
     */
    public const ISK = 'ISK';

    /**
     * Jamaican dollar
     */
    public const JMD = 'JMD';

    /**
     * Jordanian dinar
     */
    public const JOD = 'JOD';

    /**
     * Japanese yen
     */
    public const JPY = 'JPY';

    /**
     * Kenyan shilling
     */
    public const KES = 'KES';

    /**
     * Kyrgyzstani som
     */
    public const KGS = 'KGS';

    /**
     * Cambodian riel
     */
    public const KHR = 'KHR';

    /**
     * Comoro franc
     */
    public const KMF = 'KMF';

    /**
     * North Korean won
     */
    public const KPW = 'KPW';

    /**
     * South Korean won
     */
    public const KRW = 'KRW';

    /**
     * Kuwaiti dinar
     */
    public const KWD = 'KWD';

    /**
     * Cayman Islands dollar
     */
    public const KYD = 'KYD';

    /**
     * Kazakhstani tenge
     */
    public const KZT = 'KZT';

    /**
     * Lao kip
     */
    public const LAK = 'LAK';

    /**
     * Lebanese pound
     */
    public const LBP = 'LBP';

    /**
     * Sri Lankan rupee
     */
    public const LKR = 'LKR';

    /**
     * Liberian dollar
     */
    public const LRD = 'LRD';

    /**
     * Lesotho loti
     */
    public const LSL = 'LSL';

    /**
     * Lithuanian litas
     */
    public const LTL = 'LTL';

    /**
     * Latvian lats
     */
    public const LVL = 'LVL';

    /**
     * Libyan dinar
     */
    public const LYD = 'LYD';

    /**
     * Moroccan dirham
     */
    public const MAD = 'MAD';

    /**
     * Moldovan leu
     */
    public const MDL = 'MDL';

    /**
     * Malagasy ariary
     */
    public const MGA = 'MGA';

    /**
     * Macedonian denar
     */
    public const MKD = 'MKD';

    /**
     * Myanmar kyat
     */
    public const MMK = 'MMK';

    /**
     * Mongolian tögrög
     */
    public const MNT = 'MNT';

    /**
     * Macanese pataca
     */
    public const MOP = 'MOP';

    /**
     * Mauritanian ouguiya
     */
    public const MRO = 'MRO';

    /**
     * Mauritian rupee
     */
    public const MUR = 'MUR';

    /**
     * Maldivian rufiyaa
     */
    public const MVR = 'MVR';

    /**
     * Malawian kwacha
     */
    public const MWK = 'MWK';

    /**
     * Mexican peso
     */
    public const MXN = 'MXN';

    /**
     * Mexican Unidad de Inversion
     */
    public const MXV = 'MXV';

    /**
     * Malaysian ringgit
     */
    public const MYR = 'MYR';

    /**
     * Mozambican metical
     */
    public const MZN = 'MZN';

    /**
     * Namibian dollar
     */
    public const NAD = 'NAD';

    /**
     * Nigerian naira
     */
    public const NGN = 'NGN';

    /**
     * Nicaraguan córdoba
     */
    public const NIO = 'NIO';

    /**
     * Norwegian krone
     */
    public const NOK = 'NOK';

    /**
     * Nepalese rupee
     */
    public const NPR = 'NPR';

    /**
     * New Zealand dollar
     */
    public const NZD = 'NZD';

    /**
     * Omani rial
     */
    public const OMR = 'OMR';

    /**
     * Panamanian balboa
     */
    public const PAB = 'PAB';

    /**
     * Peruvian sol
     */
    public const PEN = 'PEN';

    /**
     * Papua New Guinean kina
     */
    public const PGK = 'PGK';

    /**
     * Philippine peso
     */
    public const PHP = 'PHP';

    /**
     * Pakistani rupee
     */
    public const PKR = 'PKR';

    /**
     * Polish złoty
     */
    public const PLN = 'PLN';

    /**
     * Paraguayan guaraní
     */
    public const PYG = 'PYG';

    /**
     * Qatari riyal
     */
    public const QAR = 'QAR';

    /**
     * Romanian leu
     */
    public const RON = 'RON';

    /**
     * Serbian dinar
     */
    public const RSD = 'RSD';

    /**
     * Russian ruble
     */
    public const RUB = 'RUB';

    /**
     * Rwandan franc
     */
    public const RWF = 'RWF';

    /**
     * Saudi riyal
     */
    public const SAR = 'SAR';

    /**
     * Solomon Islands dollar
     */
    public const SBD = 'SBD';

    /**
     * Seychelles rupee
     */
    public const SCR = 'SCR';

    /**
     * Sudanese pound
     */
    public const SDG = 'SDG';

    /**
     * Swedish krona
     */
    public const SEK = 'SEK';

    /**
     * Singapore dollar
     */
    public const SGD = 'SGD';

    /**
     * Saint Helena pound
     */
    public const SHP = 'SHP';

    /**
     * Sierra Leonean leone
     */
    public const SLL = 'SLL';

    /**
     * Somali shilling
     */
    public const SOS = 'SOS';

    /**
     * Surinamese dollar
     */
    public const SRD = 'SRD';

    /**
     * South Sudanese pound
     */
    public const SSP = 'SSP';

    /**
     * São Tomé and Príncipe dobra
     */
    public const STD = 'STD';

    /**
     * Salvadoran colón
     */
    public const SVC = 'SVC';

    /**
     * Syrian pound
     */
    public const SYP = 'SYP';

    /**
     * Swazi lilangeni
     */
    public const SZL = 'SZL';

    /**
     * Thai baht
     */
    public const THB = 'THB';

    /**
     * Tajikstani somoni
     */
    public const TJS = 'TJS';

    /**
     * Turkmenistan manat
     */
    public const TMT = 'TMT';

    /**
     * Tunisian dinar
     */
    public const TND = 'TND';

    /**
     * Tongan pa'anga
     */
    public const TOP = 'TOP';

    /**
     * Turkish lira
     */
    public const TRY_ = 'TRY';

    /**
     * Trinidad and Tobago dollar
     */
    public const TTD = 'TTD';

    /**
     * New Taiwan dollar
     */
    public const TWD = 'TWD';

    /**
     * Tanzanian shilling
     */
    public const TZS = 'TZS';

    /**
     * Ukrainian hryvnia
     */
    public const UAH = 'UAH';

    /**
     * Ugandan shilling
     */
    public const UGX = 'UGX';

    /**
     * United States dollar
     */
    public const USD = 'USD';

    /**
     * United States dollar (next day)
     */
    public const USN = 'USN';

    /**
     * United States dollar (same day)
     */
    public const USS = 'USS';

    /**
     * Uruguay Peso en Unidedades Indexadas
     */
    public const UYI = 'UYI';

    /**
     * Uruguyan peso
     */
    public const UYU = 'UYU';

    /**
     * Uzbekistan som
     */
    public const UZS = 'UZS';

    /**
     * Venezuelan bolívar soberano
     */
    public const VEF = 'VEF';

    /**
     * Vietnamese đồng
     */
    public const VND = 'VND';

    /**
     * Vanuatu vatu
     */
    public const VUV = 'VUV';

    /**
     * Samoan tala
     */
    public const WST = 'WST';

    /**
     * CFA franc BEAC
     */
    public const XAF = 'XAF';

    /**
     * Silver
     */
    public const XAG = 'XAG';

    /**
     * Gold
     */
    public const XAU = 'XAU';

    /**
     * European Composite Unit
     */
    public const XBA = 'XBA';

    /**
     * European Monetary Unit
     */
    public const XBB = 'XBB';

    /**
     * European Unit of Account 9
     */
    public const XBC = 'XBC';

    /**
     * European Unit of Account 17
     */
    public const XBD = 'XBD';

    /**
     * East Caribbean dollar
     */
    public const XCD = 'XCD';

    /**
     * Special drawing rights (International Monetary Fund)
     */
    public const XDR = 'XDR';

    /**
     * CFA franc BCEAO
     */
    public const XOF = 'XOF';

    /**
     * Palladium
     */
    public const XPD = 'XPD';

    /**
     * CFP franc
     */
    public const XPF = 'XPF';

    /**
     * Platinum
     */
    public const XPT = 'XPT';

    /**
     * Code reserved for testing
     */
    public const XTS = 'XTS';

    /**
     * No currency
     */
    public const XXX = 'XXX';

    /**
     * Yemeni rial
     */
    public const YER = 'YER';

    /**
     * South African rand
     */
    public const ZAR = 'ZAR';

    /**
     * Zambian kwacha
     */
    public const ZMK = 'ZMK';

    /**
     * Zambian kwacha
     */
    public const ZMW = 'ZMW';

    /**
     * Bitcoin
     */
    public const BTC = 'BTC';
}
