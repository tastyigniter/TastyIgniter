<?php
/**
 * This file is part of the Composer Merge plugin.
 *
 * Copyright (C) 2014 Bryan Davis, Wikimedia Foundation, and contributors
 *
 * This software may be modified and distributed under the terms of the MIT
 * license. See the LICENSE file for details.
 */

namespace Wikimedia\Composer\Merge;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\InstallerEvent;
use Composer\Installer\InstallerEvents;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Package\LinkConstraint\SpecificConstraint;
use Composer\Package\Loader\ArrayLoader;
use Composer\Plugin\PluginInterface;
use Composer\Script\CommandEvent;
use Composer\Script\ScriptEvents;

/**
 * Composer plugin that allows merging multiple composer.json files.
 *
 * When installed, this plugin will look for a "merge-patterns" key in the
 * composer configuration's "extra" section. The value of this setting can be
 * either a single value or an array of values. Each value is treated as
 * a glob() pattern identifying additional composer.json style configuration
 * files to merge into the configuration for the current compser execution.
 *
 * The "require", "require-dev", "repositories" and "suggest" sections of the
 * found configuration files will be merged into the root package
 * configuration as though they were directly included in the top-level
 * composer.json file.
 *
 * If included files specify conflicting package versions for "require" or
 * "require-dev", the normal Composer dependency solver process will be used
 * to attempt to resolve the conflict.
 *
 * @code
 * {
 *    "require": {
 *        "wikimedia/composer-merge-plugin": "dev-master"
 *    }
 *     "extra": {
 *         "merge-patterns": [
 *             "composer.local.json"
 *         ]
 *     }
 * }
 * @endcode
 *
 * @author Bryan Davis <bd808@bd808.com>
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{

    /**
     * @var Composer $composer
     */
    protected $composer;

    /**
     * @var IOInterface $inputOutput
     */
    protected $inputOutput;

    /**
     * @var ArrayLoader $loader
     */
    protected $loader;

    /**
     * @var array $duplicateLinks
     */
    protected $duplicateLinks;

    /**
     * @var bool $devMode
     */
    protected $devMode;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->inputOutput = $io;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            InstallerEvents::PRE_DEPENDENCIES_SOLVING => 'onDependencySolve',
            ScriptEvents::PRE_INSTALL_CMD => 'onInstallOrUpdate',
            ScriptEvents::PRE_UPDATE_CMD => 'onInstallOrUpdate',
        );
    }

    /**
     * Handle an event callback for an install or update command by checking
     * for "merge-patterns" in the "extra" data and merging package contents
     * if found.
     *
     * @param CommandEvent $event
     */
    public function onInstallOrUpdate(CommandEvent $event)
    {
        $package = $this->composer->getPackage();
        $extra = $package->getExtra();
        if (isset($extra['merge-patterns'])) {
            $this->loader = new ArrayLoader();
            $this->duplicateLinks = array(
                'require' => array(),
                'require-dev' => array(),
            );
            $this->devMode = $event->isDevMode();
            $this->mergePackages($extra['merge-patterns']);
        }
    }

    /**
     * Find configuration files matching the given glob patterns and merge
     * their contents with the master package.
     *
     * @param array $patterns Glob-style file patterns
     */
    protected function mergePackages($patterns)
    {
        $root = $this->composer->getPackage();
        $patterns = is_array($patterns) ? $patterns : array($patterns);
        foreach (
            array_reduce(
                array_map('glob', $patterns), 'array_merge', array()
            ) as $path)
        {
            $file = new JsonFile($path);
            $config = $file->read();
             if (!isset($config['name'])) {
                 $config['name'] = strtr(DIRECTORY_SEPARATOR, '-', $path);
             }
            if (!isset($config['version'])) {
                $config['version'] = '1.0.0';
            }
            $package = $this->loader->load($config);

            $root->setRequires($this->mergeLinks(
                $root->getRequires(), $package->getRequires(),
                $this->duplicateLinks['require']));

            $root->setDevRequires($this->mergeLinks(
                $root->getDevRequires(), $package->getDevRequires(),
                $this->duplicateLinks['require-dev']));

            if ($package->getRepositories()) {
                $root->setRepositories(array_merge(
                    $package->getRepositories(), $root->getRepositories()));
            }

            if ($package->getSuggests()) {
                $root->setSuggests(array_merge(
                    $pakcage->getSuggests(), $root->getRepositories()));
            }
        }
    }

    /**
     * Merge two collections of package links and collect duplicates for
     * subsequent processing.
     *
     * @param array $origin Primary collection
     * @param array $merge Additional collection
     * @param array &dups Duplicate storage
     * @return array Merged collection
     */
    protected function mergeLinks(array $origin, array $merge, array &$dups)
    {
        foreach ($merge as $name => $link) {
            if (!isset($origin[$name])) {
                $origin[$name] = $link;
            } else {
                // Defer to solver.
                $dups[] = $link;
            }
        }
        return $origin;
    }

    /**
     * Handle an event callback for pre-dependency solving phase of an install
     * or update by adding any duplicate package dependencies found during
     * initial merge processing to the request that will be processed by the
     * dependency solver.
     *
     * @param InstallerEvent $event
     */
    public function onDependencySolve(InstallerEvent $event)
    {
        $request = $event->getRequest();
        foreach ($this->duplicateLinks['require'] as $link) {
            $request->install($link->getTarget(), $link->getConstraint());
        }
        if ($this->devMode) {
            foreach ($this->duplicateLinks['require-dev'] as $link) {
                $request->install($link->getTarget(), $link->getConstraint());
            }
        }
    }

}
// vim:sw=4:ts=4:sts=4:et:
