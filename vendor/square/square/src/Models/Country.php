<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the country associated with another entity, such as a business.
 * Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm).
 */
class Country
{
    /**
     * Unknown
     */
    public const ZZ = 'ZZ';

    /**
     * Andorra
     */
    public const AD = 'AD';

    /**
     * United Arab Emirates
     */
    public const AE = 'AE';

    /**
     * Afghanistan
     */
    public const AF = 'AF';

    /**
     * Antigua and Barbuda
     */
    public const AG = 'AG';

    /**
     * Anguilla
     */
    public const AI = 'AI';

    /**
     * Albania
     */
    public const AL = 'AL';

    /**
     * Armenia
     */
    public const AM = 'AM';

    /**
     * Angola
     */
    public const AO = 'AO';

    /**
     * Antartica
     */
    public const AQ = 'AQ';

    /**
     * Argentina
     */
    public const AR = 'AR';

    /**
     * American Samoa
     */
    public const AS_ = 'AS';

    /**
     * Austria
     */
    public const AT = 'AT';

    /**
     * Australia
     */
    public const AU = 'AU';

    /**
     * Aruba
     */
    public const AW = 'AW';

    /**
     * Åland Islands
     */
    public const AX = 'AX';

    /**
     * Azerbaijan
     */
    public const AZ = 'AZ';

    /**
     * Bosnia and Herzegovina
     */
    public const BA = 'BA';

    /**
     * Barbados
     */
    public const BB = 'BB';

    /**
     * Bangladesh
     */
    public const BD = 'BD';

    /**
     * Belgium
     */
    public const BE = 'BE';

    /**
     * Burkina Faso
     */
    public const BF = 'BF';

    /**
     * Bulgaria
     */
    public const BG = 'BG';

    /**
     * Bahrain
     */
    public const BH = 'BH';

    /**
     * Burundi
     */
    public const BI = 'BI';

    /**
     * Benin
     */
    public const BJ = 'BJ';

    /**
     * Saint Barthélemy
     */
    public const BL = 'BL';

    /**
     * Bermuda
     */
    public const BM = 'BM';

    /**
     * Brunei
     */
    public const BN = 'BN';

    /**
     * Bolivia
     */
    public const BO = 'BO';

    /**
     * Bonaire
     */
    public const BQ = 'BQ';

    /**
     * Brazil
     */
    public const BR = 'BR';

    /**
     * Bahamas
     */
    public const BS = 'BS';

    /**
     * Bhutan
     */
    public const BT = 'BT';

    /**
     * Bouvet Island
     */
    public const BV = 'BV';

    /**
     * Botswana
     */
    public const BW = 'BW';

    /**
     * Belarus
     */
    public const BY = 'BY';

    /**
     * Belize
     */
    public const BZ = 'BZ';

    /**
     * Canada
     */
    public const CA = 'CA';

    /**
     * Cocos Islands
     */
    public const CC = 'CC';

    /**
     * Democratic Republic of the Congo
     */
    public const CD = 'CD';

    /**
     * Central African Republic
     */
    public const CF = 'CF';

    /**
     * Congo
     */
    public const CG = 'CG';

    /**
     * Switzerland
     */
    public const CH = 'CH';

    /**
     * Ivory Coast
     */
    public const CI = 'CI';

    /**
     * Cook Islands
     */
    public const CK = 'CK';

    /**
     * Chile
     */
    public const CL = 'CL';

    /**
     * Cameroon
     */
    public const CM = 'CM';

    /**
     * China
     */
    public const CN = 'CN';

    /**
     * Colombia
     */
    public const CO = 'CO';

    /**
     * Costa Rica
     */
    public const CR = 'CR';

    /**
     * Cuba
     */
    public const CU = 'CU';

    /**
     * Cabo Verde
     */
    public const CV = 'CV';

    /**
     * Curaçao
     */
    public const CW = 'CW';

    /**
     * Christmas Island
     */
    public const CX = 'CX';

    /**
     * Cyprus
     */
    public const CY = 'CY';

    /**
     * Czechia
     */
    public const CZ = 'CZ';

    /**
     * Germany
     */
    public const DE = 'DE';

    /**
     * Djibouti
     */
    public const DJ = 'DJ';

    /**
     * Denmark
     */
    public const DK = 'DK';

    /**
     * Dominica
     */
    public const DM = 'DM';

    /**
     * Dominican Republic
     */
    public const DO_ = 'DO';

    /**
     * Algeria
     */
    public const DZ = 'DZ';

    /**
     * Ecuador
     */
    public const EC = 'EC';

    /**
     * Estonia
     */
    public const EE = 'EE';

    /**
     * Egypt
     */
    public const EG = 'EG';

    /**
     * Western Sahara
     */
    public const EH = 'EH';

    /**
     * Eritrea
     */
    public const ER = 'ER';

    /**
     * Spain
     */
    public const ES = 'ES';

    /**
     * Ethiopia
     */
    public const ET = 'ET';

    /**
     * Finland
     */
    public const FI = 'FI';

    /**
     * Fiji
     */
    public const FJ = 'FJ';

    /**
     * Falkland Islands
     */
    public const FK = 'FK';

    /**
     * Federated States of Micronesia
     */
    public const FM = 'FM';

    /**
     * Faroe Islands
     */
    public const FO = 'FO';

    /**
     * France
     */
    public const FR = 'FR';

    /**
     * Gabon
     */
    public const GA = 'GA';

    /**
     * United Kingdom
     */
    public const GB = 'GB';

    /**
     * Grenada
     */
    public const GD = 'GD';

    /**
     * Georgia
     */
    public const GE = 'GE';

    /**
     * French Guiana
     */
    public const GF = 'GF';

    /**
     * Guernsey
     */
    public const GG = 'GG';

    /**
     * Ghana
     */
    public const GH = 'GH';

    /**
     * Gibraltar
     */
    public const GI = 'GI';

    /**
     * Greenland
     */
    public const GL = 'GL';

    /**
     * Gambia
     */
    public const GM = 'GM';

    /**
     * Guinea
     */
    public const GN = 'GN';

    /**
     * Guadeloupe
     */
    public const GP = 'GP';

    /**
     * Equatorial Guinea
     */
    public const GQ = 'GQ';

    /**
     * Greece
     */
    public const GR = 'GR';

    /**
     * South Georgia and the South Sandwich Islands
     */
    public const GS = 'GS';

    /**
     * Guatemala
     */
    public const GT = 'GT';

    /**
     * Guam
     */
    public const GU = 'GU';

    /**
     * Guinea-Bissau
     */
    public const GW = 'GW';

    /**
     * Guyana
     */
    public const GY = 'GY';

    /**
     * Hong Kong
     */
    public const HK = 'HK';

    /**
     * Heard Island and McDonald Islands
     */
    public const HM = 'HM';

    /**
     * Honduras
     */
    public const HN = 'HN';

    /**
     * Croatia
     */
    public const HR = 'HR';

    /**
     * Haiti
     */
    public const HT = 'HT';

    /**
     * Hungary
     */
    public const HU = 'HU';

    /**
     * Indonesia
     */
    public const ID = 'ID';

    /**
     * Ireland
     */
    public const IE = 'IE';

    /**
     * Israel
     */
    public const IL = 'IL';

    /**
     * Isle of Man
     */
    public const IM = 'IM';

    /**
     * India
     */
    public const IN = 'IN';

    /**
     * British Indian Ocean Territory
     */
    public const IO = 'IO';

    /**
     * Iraq
     */
    public const IQ = 'IQ';

    /**
     * Iran
     */
    public const IR = 'IR';

    /**
     * Iceland
     */
    public const IS = 'IS';

    /**
     * Italy
     */
    public const IT = 'IT';

    /**
     * Jersey
     */
    public const JE = 'JE';

    /**
     * Jamaica
     */
    public const JM = 'JM';

    /**
     * Jordan
     */
    public const JO = 'JO';

    /**
     * Japan
     */
    public const JP = 'JP';

    /**
     * Kenya
     */
    public const KE = 'KE';

    /**
     * Kyrgyzstan
     */
    public const KG = 'KG';

    /**
     * Cambodia
     */
    public const KH = 'KH';

    /**
     * Kiribati
     */
    public const KI = 'KI';

    /**
     * Comoros
     */
    public const KM = 'KM';

    /**
     * Saint Kitts and Nevis
     */
    public const KN = 'KN';

    /**
     * Democratic People's Republic of Korea
     */
    public const KP = 'KP';

    /**
     * Republic of Korea
     */
    public const KR = 'KR';

    /**
     * Kuwait
     */
    public const KW = 'KW';

    /**
     * Cayman Islands
     */
    public const KY = 'KY';

    /**
     * Kazakhstan
     */
    public const KZ = 'KZ';

    /**
     * Lao People's Democratic Republic
     */
    public const LA = 'LA';

    /**
     * Lebanon
     */
    public const LB = 'LB';

    /**
     * Saint Lucia
     */
    public const LC = 'LC';

    /**
     * Liechtenstein
     */
    public const LI = 'LI';

    /**
     * Sri Lanka
     */
    public const LK = 'LK';

    /**
     * Liberia
     */
    public const LR = 'LR';

    /**
     * Lesotho
     */
    public const LS = 'LS';

    /**
     * Lithuania
     */
    public const LT = 'LT';

    /**
     * Luxembourg
     */
    public const LU = 'LU';

    /**
     * Latvia
     */
    public const LV = 'LV';

    /**
     * Libya
     */
    public const LY = 'LY';

    /**
     * Morocco
     */
    public const MA = 'MA';

    /**
     * Monaco
     */
    public const MC = 'MC';

    /**
     * Moldova
     */
    public const MD = 'MD';

    /**
     * Montenegro
     */
    public const ME = 'ME';

    /**
     * Saint Martin
     */
    public const MF = 'MF';

    /**
     * Madagascar
     */
    public const MG = 'MG';

    /**
     * Marshall Islands
     */
    public const MH = 'MH';

    /**
     * North Macedonia
     */
    public const MK = 'MK';

    /**
     * Mali
     */
    public const ML = 'ML';

    /**
     * Myanmar
     */
    public const MM = 'MM';

    /**
     * Mongolia
     */
    public const MN = 'MN';

    /**
     * Macao
     */
    public const MO = 'MO';

    /**
     * Northern Mariana Islands
     */
    public const MP = 'MP';

    /**
     * Martinique
     */
    public const MQ = 'MQ';

    /**
     * Mauritania
     */
    public const MR = 'MR';

    /**
     * Montserrat
     */
    public const MS = 'MS';

    /**
     * Malta
     */
    public const MT = 'MT';

    /**
     * Mauritius
     */
    public const MU = 'MU';

    /**
     * Maldives
     */
    public const MV = 'MV';

    /**
     * Malawi
     */
    public const MW = 'MW';

    /**
     * Mexico
     */
    public const MX = 'MX';

    /**
     * Malaysia
     */
    public const MY = 'MY';

    /**
     * Mozambique
     */
    public const MZ = 'MZ';

    /**
     * Namibia
     */
    public const NA = 'NA';

    /**
     * New Caledonia
     */
    public const NC = 'NC';

    /**
     * Niger
     */
    public const NE = 'NE';

    /**
     * Norfolk Island
     */
    public const NF = 'NF';

    /**
     * Nigeria
     */
    public const NG = 'NG';

    /**
     * Nicaragua
     */
    public const NI = 'NI';

    /**
     * Netherlands
     */
    public const NL = 'NL';

    /**
     * Norway
     */
    public const NO = 'NO';

    /**
     * Nepal
     */
    public const NP = 'NP';

    /**
     * Nauru
     */
    public const NR = 'NR';

    /**
     * Niue
     */
    public const NU = 'NU';

    /**
     * New Zealand
     */
    public const NZ = 'NZ';

    /**
     * Oman
     */
    public const OM = 'OM';

    /**
     * Panama
     */
    public const PA = 'PA';

    /**
     * Peru
     */
    public const PE = 'PE';

    /**
     * French Polynesia
     */
    public const PF = 'PF';

    /**
     * Papua New Guinea
     */
    public const PG = 'PG';

    /**
     * Philippines
     */
    public const PH = 'PH';

    /**
     * Pakistan
     */
    public const PK = 'PK';

    /**
     * Poland
     */
    public const PL = 'PL';

    /**
     * Saint Pierre and Miquelon
     */
    public const PM = 'PM';

    /**
     * Pitcairn
     */
    public const PN = 'PN';

    /**
     * Puerto Rico
     */
    public const PR = 'PR';

    /**
     * Palestine
     */
    public const PS = 'PS';

    /**
     * Portugal
     */
    public const PT = 'PT';

    /**
     * Palau
     */
    public const PW = 'PW';

    /**
     * Paraguay
     */
    public const PY = 'PY';

    /**
     * Qatar
     */
    public const QA = 'QA';

    /**
     * Réunion
     */
    public const RE = 'RE';

    /**
     * Romania
     */
    public const RO = 'RO';

    /**
     * Serbia
     */
    public const RS = 'RS';

    /**
     * Russia
     */
    public const RU = 'RU';

    /**
     * Rwanda
     */
    public const RW = 'RW';

    /**
     * Saudi Arabia
     */
    public const SA = 'SA';

    /**
     * Solomon Islands
     */
    public const SB = 'SB';

    /**
     * Seychelles
     */
    public const SC = 'SC';

    /**
     * Sudan
     */
    public const SD = 'SD';

    /**
     * Sweden
     */
    public const SE = 'SE';

    /**
     * Singapore
     */
    public const SG = 'SG';

    /**
     * Saint Helena, Ascension and Tristan da Cunha
     */
    public const SH = 'SH';

    /**
     * Slovenia
     */
    public const SI = 'SI';

    /**
     * Svalbard and Jan Mayen
     */
    public const SJ = 'SJ';

    /**
     * Slovakia
     */
    public const SK = 'SK';

    /**
     * Sierra Leone
     */
    public const SL = 'SL';

    /**
     * San Marino
     */
    public const SM = 'SM';

    /**
     * Senegal
     */
    public const SN = 'SN';

    /**
     * Somalia
     */
    public const SO = 'SO';

    /**
     * Suriname
     */
    public const SR = 'SR';

    /**
     * South Sudan
     */
    public const SS = 'SS';

    /**
     * Sao Tome and Principe
     */
    public const ST = 'ST';

    /**
     * El Salvador
     */
    public const SV = 'SV';

    /**
     * Sint Maarten
     */
    public const SX = 'SX';

    /**
     * Syrian Arab Republic
     */
    public const SY = 'SY';

    /**
     * Eswatini
     */
    public const SZ = 'SZ';

    /**
     * Turks and Caicos Islands
     */
    public const TC = 'TC';

    /**
     * Chad
     */
    public const TD = 'TD';

    /**
     * French Southern Territories
     */
    public const TF = 'TF';

    /**
     * Togo
     */
    public const TG = 'TG';

    /**
     * Thailand
     */
    public const TH = 'TH';

    /**
     * Tajikistan
     */
    public const TJ = 'TJ';

    /**
     * Tokelau
     */
    public const TK = 'TK';

    /**
     * Timor-Leste
     */
    public const TL = 'TL';

    /**
     * Turkmenistan
     */
    public const TM = 'TM';

    /**
     * Tunisia
     */
    public const TN = 'TN';

    /**
     * Tonga
     */
    public const TO = 'TO';

    /**
     * Turkey
     */
    public const TR = 'TR';

    /**
     * Trinidad and Tobago
     */
    public const TT = 'TT';

    /**
     * Tuvalu
     */
    public const TV = 'TV';

    /**
     * Taiwan
     */
    public const TW = 'TW';

    /**
     * Tanzania
     */
    public const TZ = 'TZ';

    /**
     * Ukraine
     */
    public const UA = 'UA';

    /**
     * Uganda
     */
    public const UG = 'UG';

    /**
     * United States Minor Outlying Islands
     */
    public const UM = 'UM';

    /**
     * United States of America
     */
    public const US = 'US';

    /**
     * Uruguay
     */
    public const UY = 'UY';

    /**
     * Uzbekistan
     */
    public const UZ = 'UZ';

    /**
     * Vatican City
     */
    public const VA = 'VA';

    /**
     * Saint Vincent and the Grenadines
     */
    public const VC = 'VC';

    /**
     * Venezuela
     */
    public const VE = 'VE';

    /**
     * British Virgin Islands
     */
    public const VG = 'VG';

    /**
     * U.S. Virgin Islands
     */
    public const VI = 'VI';

    /**
     * Vietnam
     */
    public const VN = 'VN';

    /**
     * Vanuatu
     */
    public const VU = 'VU';

    /**
     * Wallis and Futuna
     */
    public const WF = 'WF';

    /**
     * Samoa
     */
    public const WS = 'WS';

    /**
     * Yemen
     */
    public const YE = 'YE';

    /**
     * Mayotte
     */
    public const YT = 'YT';

    /**
     * South Africa
     */
    public const ZA = 'ZA';

    /**
     * Zambia
     */
    public const ZM = 'ZM';

    /**
     * Zimbabwe
     */
    public const ZW = 'ZW';
}
