<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Identifiers for the location used by various governments for tax purposes.
 */
class TaxIds implements \JsonSerializable
{
    /**
     * @var array
     */
    private $euVat = [];

    /**
     * @var array
     */
    private $frSiret = [];

    /**
     * @var array
     */
    private $frNaf = [];

    /**
     * @var array
     */
    private $esNif = [];

    /**
     * Returns Eu Vat.
     * The EU VAT number for this location. For example, `IE3426675K`.
     * If the EU VAT number is present, it is well-formed and has been
     * validated with VIES, the VAT Information Exchange System.
     */
    public function getEuVat(): ?string
    {
        if (count($this->euVat) == 0) {
            return null;
        }
        return $this->euVat['value'];
    }

    /**
     * Sets Eu Vat.
     * The EU VAT number for this location. For example, `IE3426675K`.
     * If the EU VAT number is present, it is well-formed and has been
     * validated with VIES, the VAT Information Exchange System.
     *
     * @maps eu_vat
     */
    public function setEuVat(?string $euVat): void
    {
        $this->euVat['value'] = $euVat;
    }

    /**
     * Unsets Eu Vat.
     * The EU VAT number for this location. For example, `IE3426675K`.
     * If the EU VAT number is present, it is well-formed and has been
     * validated with VIES, the VAT Information Exchange System.
     */
    public function unsetEuVat(): void
    {
        $this->euVat = [];
    }

    /**
     * Returns Fr Siret.
     * The SIRET (Système d'Identification du Répertoire des Entreprises et de leurs Etablissements)
     * number is a 14-digit code issued by the French INSEE. For example, `39922799000021`.
     */
    public function getFrSiret(): ?string
    {
        if (count($this->frSiret) == 0) {
            return null;
        }
        return $this->frSiret['value'];
    }

    /**
     * Sets Fr Siret.
     * The SIRET (Système d'Identification du Répertoire des Entreprises et de leurs Etablissements)
     * number is a 14-digit code issued by the French INSEE. For example, `39922799000021`.
     *
     * @maps fr_siret
     */
    public function setFrSiret(?string $frSiret): void
    {
        $this->frSiret['value'] = $frSiret;
    }

    /**
     * Unsets Fr Siret.
     * The SIRET (Système d'Identification du Répertoire des Entreprises et de leurs Etablissements)
     * number is a 14-digit code issued by the French INSEE. For example, `39922799000021`.
     */
    public function unsetFrSiret(): void
    {
        $this->frSiret = [];
    }

    /**
     * Returns Fr Naf.
     * The French government uses the NAF (Nomenclature des Activités Françaises) to display and
     * track economic statistical data. This is also called the APE (Activite Principale de l’Entreprise)
     * code.
     * For example, `6910Z`.
     */
    public function getFrNaf(): ?string
    {
        if (count($this->frNaf) == 0) {
            return null;
        }
        return $this->frNaf['value'];
    }

    /**
     * Sets Fr Naf.
     * The French government uses the NAF (Nomenclature des Activités Françaises) to display and
     * track economic statistical data. This is also called the APE (Activite Principale de l’Entreprise)
     * code.
     * For example, `6910Z`.
     *
     * @maps fr_naf
     */
    public function setFrNaf(?string $frNaf): void
    {
        $this->frNaf['value'] = $frNaf;
    }

    /**
     * Unsets Fr Naf.
     * The French government uses the NAF (Nomenclature des Activités Françaises) to display and
     * track economic statistical data. This is also called the APE (Activite Principale de l’Entreprise)
     * code.
     * For example, `6910Z`.
     */
    public function unsetFrNaf(): void
    {
        $this->frNaf = [];
    }

    /**
     * Returns Es Nif.
     * The NIF (Numero de Identificacion Fiscal) number is a nine-character tax identifier used in Spain.
     * If it is present, it has been validated. For example, `73628495A`.
     */
    public function getEsNif(): ?string
    {
        if (count($this->esNif) == 0) {
            return null;
        }
        return $this->esNif['value'];
    }

    /**
     * Sets Es Nif.
     * The NIF (Numero de Identificacion Fiscal) number is a nine-character tax identifier used in Spain.
     * If it is present, it has been validated. For example, `73628495A`.
     *
     * @maps es_nif
     */
    public function setEsNif(?string $esNif): void
    {
        $this->esNif['value'] = $esNif;
    }

    /**
     * Unsets Es Nif.
     * The NIF (Numero de Identificacion Fiscal) number is a nine-character tax identifier used in Spain.
     * If it is present, it has been validated. For example, `73628495A`.
     */
    public function unsetEsNif(): void
    {
        $this->esNif = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->euVat)) {
            $json['eu_vat']   = $this->euVat['value'];
        }
        if (!empty($this->frSiret)) {
            $json['fr_siret'] = $this->frSiret['value'];
        }
        if (!empty($this->frNaf)) {
            $json['fr_naf']   = $this->frNaf['value'];
        }
        if (!empty($this->esNif)) {
            $json['es_nif']   = $this->esNif['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
