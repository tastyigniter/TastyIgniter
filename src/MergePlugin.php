<?php
/**
 * This file is part of the Composer Merge plugin.
 *
 * Copyright (C) 2014 Bryan Davis, Wikimedia Foundation, and contributors
 *
 * This software may be modified and distributed under the terms of the MIT
 * license. See the LICENSE file for details.
 */

namespace Wikimedia\Composer;

use Composer\Composer;
use Composer\Config;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Factory;
use Composer\Installer\InstallerEvent;
use Composer\Installer\InstallerEvents;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Package\LinkConstraint\SpecificConstraint;
use Composer\Package\Loader\ArrayLoader;
use Composer\Package\Package;
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
 *     "require": {
 *         "wikimedia/composer-merge-plugin": "dev-master"
 *     },
 *     "extra": {
 *         "merge-plugin": {
 *             "include": [
 *                 "composer.local.json"
 *             ]
 *         }
 *     }
 * }
 * @endcode
 *
 * @author Bryan Davis <bd808@bd808.com>
 */
class MergePlugin implements PluginInterface, EventSubscriberInterface
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
        $config = $this->readConfig($this->composer->getPackage());
        if ($config['include']) {
            $this->loader = new ArrayLoader();
            $this->duplicateLinks = array(
                'require' => array(),
                'require-dev' => array(),
            );
            $this->devMode = $event->isDevMode();
            $this->mergePackages($config);
        }
    }

    /**
     * @param Package $package
     * @return array
     */
    protected function readConfig(Package $package)
    {
        $config = array(
            'include' => array(),
        );
        $extra = $package->getExtra();
        if (isset($extra['merge-plugin'])) {
            $config = array_merge($config, $extra['merge-plugin']);
            if (!is_array($config['include'])) {
                $config['include'] = array($config['include']);
            }
        }
        return $config;
    }

    /**
     * Find configuration files matching the configured glob patterns and
     * merge their contents with the master package.
     *
     * @param array $config
     */
    protected function mergePackages(array $config)
    {
        $root = $this->composer->getPackage();
        foreach (array_reduce(
            array_map('glob', $config['include']),
            'array_merge',
            array()
        ) as $path) {
            $this->debug("Loading <comment>{$path}</comment>...");
            $file = new JsonFile($path);
            $json = $file->read();
            if (!isset($json['name'])) {
                $json['name'] = strtr(DIRECTORY_SEPARATOR, '-', $path);
            }
            if (!isset($json['version'])) {
                $json['version'] = '1.0.0';
            }
            $package = $this->loader->load($json);

            $root->setRequires($this->mergeLinks(
                $root->getRequires(),
                $package->getRequires(),
                $this->duplicateLinks['require']
            ));

            $root->setDevRequires($this->mergeLinks(
                $root->getDevRequires(),
                $package->getDevRequires(),
                $this->duplicateLinks['require-dev']
            ));

            if (isset($json['repositories'])) {
                $repoManager = $this->composer->getRepositoryManager();
                $newRepos = array();

                foreach ($json['repositories'] as $repoJson) {
                    $this->debug("Adding {$repoJson['type']} repository");
                    $repo = $repoManager->createRepository(
                        $repoJson['type'],
                        $repoJson
                    );
                    $repoManager->addRepository($repo);
                    $newRepos[] = $repo;
                }

                $root->setRepositories(array_merge(
                    $newRepos,
                    $root->getRepositories()
                ));
            }

            if ($package->getSuggests()) {
                $root->setSuggests(array_merge(
                    $root->getSuggests(),
                    $package->getSuggests()
                ));
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
                $this->debug("Merging <comment>{$name}</comment>");
                $origin[$name] = $link;
            } else {
                // Defer to solver.
                $this->debug("Deferring duplicate <comment>{$name}</comment>");
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
        if (!$this->duplicateLinks) {
            return;
        }

        $request = $event->getRequest();
        foreach ($this->duplicateLinks['require'] as $link) {
            $this->debug("Adding dependency <comment>{$link}</comment>");
            $request->install($link->getTarget(), $link->getConstraint());
        }
        if ($this->devMode) {
            foreach ($this->duplicateLinks['require-dev'] as $link) {
                $this->debug("Adding dev dependency <comment>{$link}</comment>");
                $request->install($link->getTarget(), $link->getConstraint());
            }
        }
    }

    /**
     * Log a debug message
     *
     * Messages will be output at the "verbose" logging level (eg `-v` needed
     * on the Composer command).
     *
     * @param string $message
     */
    protected function debug($message)
    {
        if ($this->inputOutput->isVerbose()) {
            $this->inputOutput->write("  <info>[merge]</info> {$message}");
        }
    }
}
// vim:sw=4:ts=4:sts=4:et:
