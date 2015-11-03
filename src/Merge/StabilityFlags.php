<?php
/**
 * This file is part of the Composer Merge plugin.
 *
 * Copyright (C) 2015 Bryan Davis, Wikimedia Foundation, and contributors
 *
 * This software may be modified and distributed under the terms of the MIT
 * license. See the LICENSE file for details.
 */

namespace Wikimedia\Composer\Merge;

use Composer\Package\BasePackage;
use Composer\Package\Version\VersionParser;

/**
 * Adapted from Composer's RootPackageLoader::extractStabilityFlags
 * @author Bryan Davis <bd808@bd808.com>
 */
class StabilityFlags
{

    /**
     * @var array Current package name => stability mappings
     */
    protected $stabilityFlags;

    /**
     * @var int Current default minimum stability
     */
    protected $minimumStability;

    /**
     * @var string Regex to extract an explict stability flag (eg '@dev')
     */
    protected $explicitStabilityRe;


    /**
     * @param array $stabilityFlags Current package name => stability mappings
     * @param int $minimumStability Current default minimum stability
     */
    public function __construct(
        array $stabilityFlags = array(),
        $minimumStability = BasePackage::STABILITY_STABLE
    ) {
        $this->stabilityFlags = $stabilityFlags;
        $this->minimumStability = $this->getStability($minimumStability);
        $this->explicitStabilityRe = '/^[^@]*?@(' .
            implode('|', array_keys(BasePackage::$stabilities)) .
            ')$/i';
    }

    /**
     * Get the stability value for a given string.
     *
     * @param string $name Stability name
     * @return int Stability value
     */
    protected function getStability($name)
    {
        $name = VersionParser::normalizeStability($name);
        return isset(BasePackage::$stabilities[$name]) ?
            BasePackage::$stabilities[$name] :
            BasePackage::STABILITY_STABLE;
    }

    /**
     * Extract and merge stability flags from the given collection of
     * requires with another collection of stability flags.
     *
     * @param array $requires New package name => link mappings
     * @return array Unified package name => stability mappings
     */
    public function extractAll(array $requires)
    {
        $flags = array();

        foreach ($requires as $name => $link) {
            $name = strtolower($name);
            $version = $link->getPrettyConstraint();

            $stability = $this->getExplicitStability($version);

            if ($stability === null) {
                // Drop aliasing if used
                $version = preg_replace('/^([^,\s@]+) as .+$/', '$1', $version);
                $stability = $this->getStability(
                    VersionParser::parseStability($version)
                );

                if ($stability === BasePackage::STABILITY_STABLE ||
                    $this->minimumStability > $stability
                ) {
                    // Ignore if 'stable' or more stable than the global
                    // minimum
                    $stability = null;
                }
            }

            if (isset($this->stabilityFlags[$name]) &&
                $this->stabilityFlags[$name] > $stability
            ) {
                // Keep current if more unstable
                $stability = $this->stabilityFlags[$name];
            }

            $flags[$name] = $stability;
        }

        // Filter out null stability values
        return array_filter($flags, function ($v) {
            return $v !== null;
        });
    }


    /**
     * Extract the most unstable explicit stability (eg '@dev') from a version
     * specification.
     *
     * @param string $version
     * @return int|null Stability or null if no explict stability found
     */
    protected function getExplicitStability($version)
    {
        $found = null;
        $constraints = $this->splitConstraints($version);
        foreach ($constraints as $constraint) {
            if (preg_match($this->explicitStabilityRe, $constraint, $match)) {
                $stability = $this->getStability($match[1]);
                if ($found === null || $stability > $found) {
                    $found = $stability;
                }
            }
        }
        return $found;
    }


    /**
     * Split a version specification into a list of version constraints.
     *
     * @param string $version
     * @return array
     */
    protected function splitConstraints($version)
    {
        $found = array();
        $orConstraints = preg_split('/\s*\|\|?\s*/', trim($version));
        foreach ($orConstraints as $constraints) {
            $andConstraints = preg_split(
                '/(?<!^|as|[=>< ,]) *(?<!-)[, ](?!-) *(?!,|as|$)/',
                $constraints
            );
            foreach ($andConstraints as $constraint) {
                $found[] = $constraint;
            }
        }
        return $found;
    }
}
// vim:sw=4:ts=4:sts=4:et:
