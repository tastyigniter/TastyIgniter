<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Model;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Exception\GeoliteException;
use InvalidArgumentException;

/**
 * Ellipsoid class
 *
 * @author Antoine Corcy <contact@sbin.dk>
 *
 * @see    http://en.wikipedia.org/wiki/Reference_ellipsoid
 * @see    http://www.colorado.edu/geography/gcraft/notes/datum/gif/ellipse.gif
 */
class Ellipsoid
{
    /**
     * List of selected reference ellipsoids.
     *
     * @var string
     */
    public const AIRY = 'AIRY';

    public const AUSTRALIAN_NATIONAL = 'AUSTRALIAN_NATIONAL';

    public const BESSEL_1841 = 'BESSEL_1841';

    public const BESSEL_1841_NAMBIA = 'BESSEL_1841_NAMBIA';

    public const CLARKE_1866 = 'CLARKE_1866';

    public const CLARKE_1880 = 'CLARKE_1880';

    public const EVEREST = 'EVEREST';

    public const FISCHER_1960_MERCURY = 'FISCHER_1960_MERCURY';

    public const FISCHER_1968 = 'FISCHER_1968';

    public const GRS_1967 = 'GRS_1967';

    public const GRS_1980 = 'GRS_1980';

    public const HELMERT_1906 = 'HELMERT_1906';

    public const HOUGH = 'HOUGH';

    public const INTERNATIONAL = 'INTERNATIONAL';

    public const KRASSOVSKY = 'KRASSOVSKY';

    public const MODIFIED_AIRY = 'MODIFIED_AIRY';

    public const MODIFIED_EVEREST = 'MODIFIED_EVEREST';

    public const MODIFIED_FISCHER_1960 = 'MODIFIED_FISCHER_1960';

    public const SOUTH_AMERICAN_1969 = 'SOUTH_AMERICAN_1969';

    public const WGS60 = 'WGS60';

    public const WGS66 = 'WGS66';

    public const WGS72 = 'WGS72';

    public const WGS84 = 'WGS84';

    /**
     * Selected reference ellipsoids.
     * Source: Defense Mapping Agency. 1987b. Washington, DC: Defense Mapping Agency
     * DMA Technical Report: Supplement to Department of Defense World Geodetic System 1984 Technical Report.
     * @see http://en.wikipedia.org/wiki/Geodetic_datum
     * @see http://www.colorado.edu/geography/gcraft/notes/datum/gif/refellip.gif
     */
    protected static array $referenceEllipsoids = [
        self::AIRY => [
            'name' => 'Airy',
            'a' => 6377563.396,
            'invF' => 299.3249646,
        ],
        self::AUSTRALIAN_NATIONAL => [
            'name' => 'Australian National',
            'a' => 6378160.0,
            'invF' => 298.25,
        ],
        self::BESSEL_1841 => [
            'name' => 'Bessel 1841',
            'a' => 6377397.155,
            'invF' => 299.1528128,
        ],
        self::BESSEL_1841_NAMBIA => [
            'name' => 'Bessel 1841 (Nambia)',
            'a' => 6377483.865,
            'invF' => 299.1528128,
        ],
        self::CLARKE_1866 => [
            'name' => 'Clarke 1866',
            'a' => 6378206.4,
            'invF' => 294.9786982,
        ],
        self::CLARKE_1880 => [
            'name' => 'Clarke 1880',
            'a' => 6378249.145,
            'invF' => 293.465,
        ],
        self::EVEREST => [
            'name' => 'Everest',
            'a' => 6377276.345,
            'invF' => 300.8017,
        ],
        self::FISCHER_1960_MERCURY => [
            'name' => 'Fischer 1960 (Mercury)',
            'a' => 6378166.0,
            'invF' => 298.3,
        ],
        self::FISCHER_1968 => [
            'name' => 'Fischer 1968',
            'a' => 6378150.0,
            'invF' => 298.3,
        ],
        self::GRS_1967 => [
            'name' => 'GRS 1967',
            'a' => 6378160.0,
            'invF' => 298.247167427,
        ],
        self::GRS_1980 => [
            'name' => 'GRS 1980',
            'a' => 6378137,
            'invF' => 298.257222101,
        ],
        self::HELMERT_1906 => [
            'name' => 'Helmert 1906',
            'a' => 6378200.0,
            'invF' => 298.3,
        ],
        self::HOUGH => [
            'name' => 'Hough',
            'a' => 6378270.0,
            'invF' => 297.0,
        ],
        self::INTERNATIONAL => [
            'name' => 'International',
            'a' => 6378388.0,
            'invF' => 297.0,
        ],
        self::KRASSOVSKY => [
            'name' => 'Krassovsky',
            'a' => 6378245.0,
            'invF' => 298.3,
        ],
        self::MODIFIED_AIRY => [
            'name' => 'Modified Airy',
            'a' => 6377340.189,
            'invF' => 299.3249646,
        ],
        self::MODIFIED_EVEREST => [
            'name' => 'Modified Everest',
            'a' => 6377304.063,
            'invF' => 300.8017,
        ],
        self::MODIFIED_FISCHER_1960 => [
            'name' => 'Modified Fischer 1960',
            'a' => 6378155.0,
            'invF' => 298.3,
        ],
        self::SOUTH_AMERICAN_1969 => [
            'name' => 'South American 1969',
            'a' => 6378160.0,
            'invF' => 298.25,
        ],
        self::WGS60 => [
            'name' => 'WGS 60',
            'a' => 6378165.0,
            'invF' => 298.3,
        ],
        self::WGS66 => [
            'name' => 'WGS 66',
            'a' => 6378145.0,
            'invF' => 298.25,
        ],
        self::WGS72 => [
            'name' => 'WGS 72',
            'a' => 6378135.0,
            'invF' => 298.26,
        ],
        self::WGS84 => [
            'name' => 'WGS 84',
            'a' => 6378136.0,
            'invF' => 298.257223563,
        ],
    ];

    /**
     * Create a new ellipsoid.
     *
     * @param string $name The name of the ellipsoid to create.
     * @param float $a The semi-major axis (equatorial radius) in meters.
     * @param ?float $invF The inverse flattening.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(protected string $name, protected float $a, protected ?float $invF)
    {
        if ((float)$invF <= 0.0) {
            throw new GeoliteException('The inverse flattening cannot be negative or equal to zero !');
        }
    }

    /**
     * Create the ellipsoid chosen by its name.
     */
    public static function createFromName(string $name = self::WGS84): self
    {
        $name = trim($name);

        if (empty($name)) {
            throw new GeoliteException('Please provide an ellipsoid name !');
        }

        if (!array_key_exists($name, self::$referenceEllipsoids)) {
            throw new GeoliteException(
                sprintf('%s ellipsoid does not exist in selected reference ellipsoids !', $name),
            );
        }

        return self::createFromArray(self::$referenceEllipsoids[$name]);
    }

    /**
     * Create an ellipsoid from an array.
     */
    public static function createFromArray(array $newEllipsoid): self
    {
        if (!isset($newEllipsoid['name'], $newEllipsoid['a'], $newEllipsoid['invF']) || count($newEllipsoid) !== 3) {
            throw new GeoliteException('Ellipsoid arrays should contain `name`, `a` and `invF` keys !');
        }

        return new self($newEllipsoid['name'], $newEllipsoid['a'], $newEllipsoid['invF']);
    }

    /**
     * Check if coordinates have the same ellipsoid.
     */
    public static function checkCoordinatesEllipsoid(CoordinatesInterface $a, CoordinatesInterface $b): void
    {
        if ($a->getEllipsoid()->getName() !== $b->getEllipsoid()->getName()) {
            throw new GeoliteException('The ellipsoids for both coordinates must match !');
        }
    }

    /**
     * Returns the ellipsoid's name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the semi-major axis (equatorial radius) in meters.
     */
    public function getA(): float
    {
        return $this->a;
    }

    /**
     * Computes and returns the semi-minor axis (polar distance) in meters.
     * @see http://home.online.no/~sigurdhu/WGS84_Eng.html
     */
    public function getB(): float
    {
        return $this->a * (1 - 1 / $this->invF);
    }

    /**
     * Returns the inverse flattening.
     */
    public function getInvF(): float
    {
        return (float)$this->invF;
    }

    /**
     * Computes and returns the arithmetic mean radius in meters.
     * @see http://home.online.no/~sigurdhu/WGS84_Eng.html
     */
    public function getArithmeticMeanRadius(): float
    {
        return $this->a * (1 - 1 / $this->invF / 3);
    }

    /**
     * Returns the list of available ellipsoids sorted by alphabetical order.
     */
    public static function getAvailableEllipsoidNames(): string
    {
        ksort(self::$referenceEllipsoids);

        return implode(', ', array_keys(self::$referenceEllipsoids));
    }
}
