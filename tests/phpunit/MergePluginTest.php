<?php
/**
 * This file is part of the Composer Merge plugin.
 *
 * Copyright (C) 2015 Bryan Davis, Wikimedia Foundation, and contributors
 *
 * This software may be modified and distributed under the terms of the MIT
 * license. See the LICENSE file for details.
 */

namespace Wikimedia\Composer;

use Wikimedia\Composer\Merge\ExtraPackage;
use Wikimedia\Composer\Merge\PluginState;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\Installer\InstallerEvent;
use Composer\Installer\InstallerEvents;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\BasePackage;
use Composer\Package\Link;
use Composer\Package\Locker;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Version\VersionParser;
use Composer\Plugin\PluginEvents;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Prophecy\Argument;
use ReflectionProperty;

/**
 * @covers Wikimedia\Composer\Logger
 * @covers Wikimedia\Composer\Merge\ExtraPackage
 * @covers Wikimedia\Composer\Merge\NestedArray
 * @covers Wikimedia\Composer\Merge\PluginState
 * @covers Wikimedia\Composer\Merge\StabilityFlags
 * @covers Wikimedia\Composer\MergePlugin
 */
class MergePluginTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @var MergePlugin
     */
    protected $fixture;

    protected function setUp()
    {
        parent::setUp();
        $this->composer = $this->prophesize('Composer\Composer');
        $this->io = $this->prophesize('Composer\IO\IOInterface');

        $this->fixture = new MergePlugin();
        $this->fixture->activate(
            $this->composer->reveal(),
            $this->io->reveal()
        );
    }

    public function testSubscribedEvents()
    {
        $subscriptions = MergePlugin::getSubscribedEvents();
        $this->assertEquals(8, count($subscriptions));
        $this->assertArrayHasKey(
            InstallerEvents::PRE_DEPENDENCIES_SOLVING,
            $subscriptions
        );
        $this->assertArrayHasKey(MergePlugin::COMPAT_PLUGINEVENTS_INIT, $subscriptions);
        $this->assertArrayHasKey(ScriptEvents::PRE_INSTALL_CMD, $subscriptions);
        $this->assertArrayHasKey(ScriptEvents::PRE_UPDATE_CMD, $subscriptions);
        $this->assertArrayHasKey(ScriptEvents::PRE_AUTOLOAD_DUMP, $subscriptions);
        $this->assertArrayHasKey(PackageEvents::POST_PACKAGE_INSTALL, $subscriptions);
        $this->assertArrayHasKey(ScriptEvents::POST_INSTALL_CMD, $subscriptions);
        $this->assertArrayHasKey(ScriptEvents::POST_UPDATE_CMD, $subscriptions);
    }

    /**
     * Given a root package with no requires
     *   and a composer.local.json with one require
     * When the plugin is run
     * Then the root package should inherit the require
     *   and no modifications should be made by the pre-dependency hook.
     */
    public function testOneMergeNoConflicts()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(1, count($requires));
                $that->assertArrayHasKey('monolog/monolog', $requires);
            }
        );

        $root->getConflicts()->shouldBeCalled();
        $root->setConflicts(Argument::type('array'))->will(
            function ($args) use ($that) {
                $suggest = $args[0];
                $that->assertEquals(1, count($suggest));
                $that->assertArrayHasKey('conflict/conflict', $suggest);
            }
        );
        $root->getReplaces()->shouldBeCalled();
        $root->setReplaces(Argument::type('array'))->will(
            function ($args) use ($that) {
                $suggest = $args[0];
                $that->assertEquals(1, count($suggest));
                $that->assertArrayHasKey('replace/replace', $suggest);
            }
        );
        $root->getProvides()->shouldBeCalled();
        $root->setProvides(Argument::type('array'))->will(
            function ($args) use ($that) {
                $suggest = $args[0];
                $that->assertEquals(1, count($suggest));
                $that->assertArrayHasKey('provide/provide', $suggest);
            }
        );
        $root->getSuggests()->shouldBeCalled();
        $root->setSuggests(Argument::type('array'))->will(
            function ($args) use ($that) {
                $suggest = $args[0];
                $that->assertEquals(1, count($suggest));
                $that->assertArrayHasKey('suggest/suggest', $suggest);
            }
        );

        $root->getRepositories()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with requires
     *   and a composer.local.json with requires
     *   and the same package is listed in multiple files
     * When the plugin is run
     * Then the root package should inherit the non-conflicting requires
     *   and conflicting requires should be resolved 'last defined wins'.
     */
    public function testMergeWithReplace()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(2, count($requires));
                $that->assertArrayHasKey('monolog/monolog', $requires);
                $that->assertEquals(
                    '1.10.0',
                    $requires['monolog/monolog']->getPrettyConstraint()
                );
            }
        );

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with no requires
     *   and a composer.local.json with one require, which includes a composer.local.2.json
     *   and a composer.local.2.json with one additional require
     * When the plugin is run
     * Then the root package should inherit both requires
     *   and no modifications should be made by the pre-dependency hook.
     */
    public function testRecursiveIncludes()
    {
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $packages = array();
        $root->setRequires(Argument::type('array'))->will(
            function ($args) use (&$packages) {
                $packages = array_merge($packages, $args[0]);
            }
        );

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertArrayHasKey('foo', $packages);
        $this->assertArrayHasKey('monolog/monolog', $packages);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with no requires that disables recursion
     *   and a composer.local.json with one require, which includes a composer.local.2.json
     *   and a composer.local.2.json with one additional require
     * When the plugin is run
     * Then the root package should inherit the first require
     *   and no modifications should be made by the pre-dependency hook.
     */
    public function testRecursiveIncludesDisabled()
    {
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $packages = array();
        $root->setRequires(Argument::type('array'))->will(
            function ($args) use (&$packages) {
                $packages = array_merge($packages, $args[0]);
            }
        );

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertArrayHasKey('foo', $packages);
        $this->assertArrayNotHasKey('monolog/monolog', $packages);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with requires
     *   and a composer.local.json with requires
     *   and the same package is listed in multiple files
     * When the plugin is run
     * Then the root package should inherit the non-conflicting requires
     *   and extra installs should be proposed by the pre-dependency hook.
     *
     * @param bool $fireInit Fire the INIT event?
     * @dataProvider provideFireInit
     */
    public function testOneMergeWithConflicts($fireInit)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(2, count($requires));
                $that->assertArrayHasKey(
                    'wikimedia/composer-merge-plugin',
                    $requires
                );
                $that->assertArrayHasKey('monolog/monolog', $requires);
            }
        );

        $root->getDevRequires()->shouldBeCalled();
        $root->setDevRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(2, count($requires));
                $that->assertArrayHasKey('foo', $requires);
                $that->assertArrayHasKey('xyzzy', $requires);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir, $fireInit);

        $this->assertEquals(2, count($extraInstalls));
        $this->assertEquals('monolog/monolog', $extraInstalls[0][0]);
        $this->assertEquals('foo', $extraInstalls[1][0]);
    }


    /**
     * Given a root package
     *   and a composer.local.json with a repository
     * When the plugin is run
     * Then the root package should inherit the repository
     */
    public function testMergedRepositories()
    {
        $that = $this;
        $io = $this->io;
        $dir = $this->fixtureDir(__FUNCTION__);

        $repoManager = $this->prophesize(
            'Composer\Repository\RepositoryManager'
        );
        $repoManager->createRepository(
            Argument::type('string'),
            Argument::type('array')
        )->will(
            function ($args) use ($that, $io) {
                $that->assertEquals('vcs', $args[0]);
                $that->assertEquals(
                    'https://github.com/bd808/composer-merge-plugin.git',
                    $args[1]['url']
                );

                return new \Composer\Repository\VcsRepository(
                    $args[1],
                    $io->reveal(),
                    new \Composer\Config()
                );
            }
        );
        $repoManager->prependRepository(Argument::any())->will(
            function ($args) use ($that) {
                $that->assertInstanceOf(
                    'Composer\Repository\VcsRepository',
                    $args[0]
                );
            }
        );
        $this->composer->getRepositoryManager()->will(
            function () use ($repoManager) {
                return $repoManager->reveal();
            }
        );

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(1, count($requires));
                $that->assertArrayHasKey(
                    'wikimedia/composer-merge-plugin',
                    $requires
                );
            }
        );

        $root->setDevRequires()->shouldNotBeCalled();

        $root->setRepositories(Argument::type('array'))->will(
            function ($args) use ($that) {
                $repos = $args[0];
                $that->assertEquals(1, count($repos));
            }
        );

        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * Given a root package with an extra section
     *   and a composer.local.json with a repository
     * When the plugin is run
     * Then the repository from composer.local.json should be prepended to root package repository list
     */
    public function testPrependRepositories()
    {
        $that = $this;
        $io = $this->io;
        $dir = $this->fixtureDir(__FUNCTION__);

        $repoManager = $this->prophesize(
            'Composer\Repository\RepositoryManager'
        );
        $repoManager->createRepository(
            Argument::type('string'),
            Argument::type('array')
        )->will(
            function ($args) use ($that, $io) {
                $that->assertEquals('vcs', $args[0]);
                $that->assertEquals(
                    'https://github.com/furgas/composer-merge-plugin.git',
                    $args[1]['url']
                );

                return new \Composer\Repository\VcsRepository(
                    $args[1],
                    $io->reveal(),
                    new \Composer\Config()
                );
            }
        );
        $repoManager->prependRepository(Argument::any())->will(
            function ($args) use ($that) {
                $that->assertInstanceOf(
                    'Composer\Repository\VcsRepository',
                    $args[0]
                );
            }
        );
        $this->composer->getRepositoryManager()->will(
            function () use ($repoManager) {
                return $repoManager->reveal();
            }
        );

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires()->shouldNotBeCalled();
        $root->setDevRequires()->shouldNotBeCalled();

        $root->setRepositories(Argument::type('array'))->will(
            function ($args) use ($that) {
                $repos = $args[0];
                $that->assertEquals(2, count($repos));
                $prependedRepo = $repos[0];
                $that->assertInstanceOf('Composer\Repository\VcsRepository', $prependedRepo);
                $that->assertAttributeEquals(
                    'https://github.com/furgas/composer-merge-plugin.git',
                    'url',
                    $prependedRepo
                );
            }
        );

        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * Given a root package
     *   and a composer.local.json with required packages
     * When the plugin is run
     * Then the root package should be updated with stability flags.
     *
     * @param bool $fireInit Fire the INIT event?
     * @dataProvider provideFireInit
     */
    public function testUpdateStabilityFlags($fireInit)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(7, count($requires));
                $that->assertArrayHasKey('test/foo', $requires);
                $that->assertArrayHasKey('test/bar', $requires);
                $that->assertArrayHasKey('test/baz', $requires);
                $that->assertArrayHasKey('test/xyzzy', $requires);
                $that->assertArrayHasKey('test/plugh', $requires);
                $that->assertArrayHasKey('test/plover', $requires);
                $that->assertArrayHasKey('test/bedquilt', $requires);
            }
        );

        $root->setStabilityFlags(Argument::type('array'))->will(
            function ($args) use ($that, &$expects) {
                $that->assertSame(
                    array(
                        'test/foo' => BasePackage::STABILITY_DEV,
                        'test/bar' => BasePackage::STABILITY_BETA,
                        'test/baz' => BasePackage::STABILITY_ALPHA,
                        'test/xyzzy' => BasePackage::STABILITY_RC,
                        'test/plugh' => BasePackage::STABILITY_STABLE,
                    ),
                    $args[0]
                );
            }
        );

        $root->setDevRequires(Argument::any())->shouldNotBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->setRepositories(Argument::any())->shouldNotBeCalled();

        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();
        $root->setSuggests(Argument::any())->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir, $fireInit);

        $this->assertEquals(0, count($extraInstalls));
    }


    public function testMergedAutoload()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $autoload = array();

        $root->getAutoload()->shouldBeCalled();
        $root->getDevAutoload()->shouldBeCalled();
        $root->setAutoload(Argument::type('array'))->will(
            function ($args, $root) use (&$autoload) {
                // Can't easily assert directly since there will be multiple
                // calls to this setter to create our final expected state
                $autoload = $args[0];
                // Return the new data for the next call to getAutoLoad()
                $root->getAutoload()->willReturn($args[0]);
            }
        )->shouldBeCalledTimes(2);
        $root->setDevAutoload(Argument::type('array'))->will(
            function ($args) use ($that) {
                $that->assertEquals(
                    array(
                        'psr-4' => array(
                            'Dev\\Kittens\\' => array(
                                'everywhere/',
                                'extensions/Foo/a/',
                                'extensions/Foo/b/',
                            ),
                            'Dev\\Cats\\' => 'extensions/Foo/src/'
                        ),
                        'psr-0' => array(
                            'DevUniqueGlobalClass' => 'extensions/Foo/',
                            '' => 'extensions/Foo/dev/fallback/'
                        ),
                        'files' => array(
                            'extensions/Foo/DevSemanticMediaWiki.php',
                        ),
                        'classmap' => array(
                            'extensions/Foo/DevSemanticMediaWiki.hooks.php',
                            'extensions/Foo/dev/includes/',
                        ),
                    ),
                    $args[0]
                );
            }
        )->shouldBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
        $this->assertEquals(
            array(
                'psr-4' => array(
                    'Kittens\\' => array(
                        'everywhere/',
                        'extensions/Foo/a/',
                        'extensions/Foo/b/',
                    ),
                    'Cats\\' => 'extensions/Foo/src/'
                ),
                'psr-0' => array(
                    'UniqueGlobalClass' => 'extensions/Foo/',
                    '' => 'extensions/Foo/fallback/',
                ),
                'files' => array(
                    'private/bootstrap.php',
                    'extensions/Foo/SemanticMediaWiki.php',
                ),
                'classmap' => array(
                    'extensions/Foo/SemanticMediaWiki.hooks.php',
                    'extensions/Foo/includes/',
                ),
            ),
            $autoload
        );
    }


    /**
     * Given a root package with an extra section
     *   and a composer.local.json with an extra section with no conflicting keys
     * When the plugin is run
     * Then the root package extra section should be extended with content from the local config.
     *
     * @param bool $fireInit Fire the INIT event?
     * @dataProvider provideFireInit
     */
    public function testMergeExtra($fireInit)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setExtra(Argument::type('array'))->will(
            function ($args) use ($that) {
                $extra = $args[0];
                $that->assertEquals(2, count($extra));
                $that->assertArrayHasKey('merge-plugin', $extra);
                $that->assertEquals(2, count($extra['merge-plugin']));
                $that->assertArrayHasKey('wibble', $extra);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir, $fireInit);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with an extra section
     *   and a composer.local.json with an extra section with a conflicting key
     * When the plugin is run
     * Then the version in the root package should win.
     */
    public function testMergeExtraConflict()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setExtra(Argument::type('array'))->will(
            function ($args) use ($that) {
                $extra = $args[0];
                $that->assertEquals(2, count($extra));
                $that->assertArrayHasKey('merge-plugin', $extra);
                $that->assertArrayHasKey('wibble', $extra);
                $that->assertEquals('wobble', $extra['wibble']);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with an extra section
     *   and replace mode is active
     *   and a composer.local.json with an extra section with a conflicting key
     * When the plugin is run
     * Then the version in the composer.local.json package should win.
     */
    public function testMergeExtraConflictReplace()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setExtra(Argument::type('array'))->will(
            function ($args) use ($that) {
                $extra = $args[0];
                $that->assertEquals(2, count($extra));
                $that->assertArrayHasKey('merge-plugin', $extra);
                $that->assertArrayHasKey('wibble', $extra);
                $that->assertEquals('ping', $extra['wibble']);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * Given a root package with an extra section
     *   and a composer.local.json with an extra section with conflicting keys that are arrays
     *   and the 'merge-extra-deep' option being activated
     * When the plugin is run
     * Then the root package extra section should be extended with content from the base config
     *   and deep keys should be merged together, but root config wins on key conflicts.
     *
     * @dataProvider provideDeepMerge
     */
    public function testMergeExtraDeep($suffix, $replace)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__ . $suffix);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setExtra(Argument::type('array'))->will(
            function ($args) use ($that, $replace) {
                $extra = $args[0];
                $that->assertEquals(3, count($extra));
                $that->assertArrayHasKey('merge-plugin', $extra);
                $that->assertEquals(4, count($extra['merge-plugin']));
                $that->assertArrayHasKey('patches', $extra);
                $that->assertArrayHasKey('wikimedia/composer-merge-plugin', $extra['patches']);
                $patches = $extra['patches']['wikimedia/composer-merge-plugin'];
                $key = 'Allow merging of sections in a deep way';
                $that->assertEquals('patches/add-merge-extra-deep-option.diff', $patches[$key]);
                $key = 'Add tests for merge-extra-deep option';
                $that->assertEquals('patches/add-tests-for-merge-extra-deep-option.diff', $patches[$key]);
                $that->assertArrayHasKey('somevendor/some-project', $extra['patches']);
                $that->assertArrayHasKey('some-patch', $extra['patches']['somevendor/some-project']);
                $value = $extra['patches']['somevendor/some-project']['some-patch'];
                $that->assertEquals('patches/overridden-patch.diff', $value);
                if (!$replace) {
                    $that->assertArrayHasKey('base-patch', $extra['patches']['somevendor/some-project']);
                    $value = $extra['patches']['somevendor/some-project']['base-patch'];
                    $that->assertEquals('patches/always-patch.diff', $value);
                }
                $that->assertArrayHasKey('anothervendor/some-project', $extra['patches']);
                $that->assertArrayHasKey('another-patch', $extra['patches']['anothervendor/some-project']);
                $that->assertEquals(array('first', 'second', 'third', 'fourth'), $extra['list']);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    public function provideDeepMerge()
    {
        return array(
            array('Replace', true),
            array('', false),
        );
    }

    /**
     * Given a root package with an scripts section
     *   and a composer.local.json with an extra section with no conflicting keys
     * When the plugin is run
     * Then the root package scripts section should be extended with content from the local config.
     *
     * @param bool $fireInit Fire the INIT event?
     *
     * @dataProvider provideFireInit
     */
    public function testMergeScripts($fireInit)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setScripts(Argument::type('array'))->will(
            function ($args) use ($that) {
                $scripts = $args[0];
                $that->assertEquals(2, count($scripts));
                $that->assertArrayHasKey('example-script', $scripts);
                $that->assertEquals(2, count($scripts['example-script']));
                $that->assertArrayHasKey('example-script2', $scripts);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $scriptsInstalls = $this->triggerPlugin($root->reveal(), $dir, $fireInit);

        $this->assertEquals(0, count($scriptsInstalls));
    }

    /**
     * Given a root package with an scripts section
     *   and a composer.local.json with an extra section with a conflicting key
     * When the plugin is run
     * Then the version in the root package should win.
     */
    public function testMergeScriptsConflict()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setScripts(Argument::type('array'))->will(
            function ($args) use ($that) {
                $scripts = $args[0];
                $that->assertEquals(3, count($scripts));
                $that->assertArrayHasKey('example-script2', $scripts);
                $that->assertArrayHasKey('example-script3', $scripts);
                $that->assertEquals("echo 'goodbye world'", $scripts['example-script2']);
                $that->assertEquals(1, count($scripts['example-script3']));
                $that->assertEquals("echo 'adios world'", $scripts['example-script3'][0]);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * Given a root package with a scripts section
     *   and replace mode is active
     *   and a composer.local.json with a scripts section with a conflicting key
     * When the plugin is run
     * Then the version in the composer.local.json package should win.
     */
    public function testMergeScriptsConflictReplace()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setScripts(Argument::type('array'))->will(
            function ($args) use ($that) {
                $scripts = $args[0];
                $that->assertEquals(3, count($scripts));
                $that->assertArrayHasKey('example-script', $scripts);
                $that->assertArrayHasKey('example-script2', $scripts);
                $that->assertEquals(1, count($scripts['example-script2']));
                $that->assertEquals("echo 'hello world'", $scripts['example-script2'][0]);
                $that->assertEquals(1, count($scripts['example-script3']));
                $that->assertEquals("echo 'hola world'", $scripts['example-script3'][0]);
            }
        )->shouldBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->getConflicts()->shouldNotBeCalled();
        $root->getReplaces()->shouldNotBeCalled();
        $root->getProvides()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * @dataProvider provideOnPostPackageInstall
     * @param string $package Package installed
     * @param bool $first Expected isFirstInstall() value
     * @param bool $locked Expected wasLocked() value
     */
    public function testOnPostPackageInstall($package, $first, $locked)
    {
        $operation = new InstallOperation(
            new Package($package, '1.2.3.4', '1.2.3')
        );
        $event = $this->prophesize('Composer\Installer\PackageEvent');
        $event->getOperation()->willReturn($operation)->shouldBeCalled();

        if ($first) {
            $locker = $this->prophesize('Composer\Package\Locker');
            $locker->isLocked()->willReturn($locked)->shouldBeCalled();
            $this->composer->getLocker()->willReturn($locker->reveal())
                ->shouldBeCalled();
            $event->getComposer()->willReturn($this->composer->reveal())
                ->shouldBeCalled();
        }

        $this->fixture->onPostPackageInstall($event->reveal());
        $this->assertEquals($first, $this->getState()->isFirstInstall());
        $this->assertEquals($locked, $this->getState()->isLocked());
    }


    public function provideOnPostPackageInstall()
    {
        return array(
            array(MergePlugin::PACKAGE_NAME, true, true),
            array(MergePlugin::PACKAGE_NAME, true, false),
            array('foo/bar', false, false),
        );
    }


    /**
     * Given a root package with a branch alias
     * When the plugin is run
     * Then the alias is used directly for some calls.
     *
     * @param bool $fireInit Fire the INIT event?
     * @dataProvider provideFireInit
     */
    public function testHasBranchAlias($fireInit)
    {
        $that = $this;
        $io = $this->io;
        $dir = $this->fixtureDir(__FUNCTION__);

        // RootAliasPackage was updated in 06c44ce to include more setters
        // that we take advantage of if available
        $haveComposerWithCompleteRootAlias = method_exists(
            'Composer\Package\RootPackageInterface',
            'setRepositories'
        );

        $repoManager = $this->prophesize(
            'Composer\Repository\RepositoryManager'
        );
        $repoManager->createRepository(
            Argument::type('string'),
            Argument::type('array')
        )->will(function ($args) use ($that, $io) {
            return new \Composer\Repository\VcsRepository(
                $args[1],
                $io->reveal(),
                new \Composer\Config()
            );
        });
        $repoManager->prependRepository(Argument::any())->shouldBeCalled();
        $this->composer->getRepositoryManager()->will(
            function () use ($repoManager) {
                return $repoManager->reveal();
            }
        );

        $root = $this->rootFromJson("{$dir}/composer.json");

        // Always handled by alias
        $root->setDevRequires(Argument::type('array'))->shouldNotBeCalled();
        $root->setRequires(Argument::type('array'))->shouldNotBeCalled();

        $alias = $this->makeAliasFor($root->reveal());
        $alias->getExtra()->shouldBeCalled();
        $alias->setDevRequires(Argument::type('array'))->shouldBeCalled();
        $alias->setRequires(Argument::type('array'))->shouldBeCalled();

        if ($haveComposerWithCompleteRootAlias) {
            // When Composer supports it we will apply our changes directly to
            // the RootAliasPackage
            $alias->setAutoload(Argument::type('array'))->shouldBeCalled();
            $alias->setConflicts(Argument::type('array'))->shouldBeCalled();
            $alias->setDevAutoload(Argument::type('array'))->shouldBeCalled();
            $alias->setProvides(Argument::type('array'))->shouldBeCalled();
            $alias->setReplaces(Argument::type('array'))->shouldBeCalled();
            $alias->setRepositories(Argument::type('array'))->shouldBeCalled();
            $alias->setStabilityFlags(Argument::type('array'))->shouldBeCalled();
            $alias->setSuggests(Argument::type('array'))->shouldBeCalled();
        } else {
            // With older versions of Composer we will fall back to unwrapping
            // the aliased RootPackage and make calls to it
            $root->setAutoload(Argument::type('array'))->shouldBeCalled();
            $root->setConflicts(Argument::type('array'))->shouldBeCalled();
            $root->setDevAutoload(Argument::type('array'))->shouldBeCalled();
            $root->setProvides(Argument::type('array'))->shouldBeCalled();
            $root->setReplaces(Argument::type('array'))->shouldBeCalled();
            $root->setRepositories(Argument::type('array'))->shouldBeCalled();
            $root->setSuggests(Argument::type('array'))->shouldBeCalled();
            $alias->getAliasOf()->shouldBeCalled();
        }

        $alias = $alias->reveal();

        $this->triggerPlugin($alias, $dir, $fireInit);
    }


    /**
     * Given a root package with requires
     *   and a b.json with requires
     *   and an a.json with requires
     *   and a glob of json files with requires
     * When the plugin is run
     * Then the root package should inherit the requires
     *   in the correct order based on inclusion order
     *   for individual files and alpha-numeric sorting
     *   for files included via a glob.
     *
     * @return void
     */
    public function testCorrectMergeOrderOfSpecifiedFilesAndGlobFiles()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $expects = array(
            "merge-plugin/b.json",
            "merge-plugin/a.json",
            "merge-plugin/glob-a-glob2.json",
            "merge-plugin/glob-b-glob1.json"
        );

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that, &$expects) {
                $expectedSource = array_shift($expects);
                $that->assertEquals(
                    $expectedSource,
                    $args[0]['wibble/wobble']->getSource()
                );
            }
        );
        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);
    }


    /**
     * Test replace link with self.version as version constraint.
     */
    public function testSelfVersion()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setReplaces(Argument::type('array'))->will(
            function ($args) use ($that) {
                $replace = $args[0];
                $that->assertEquals(3, count($replace));

                $that->assertArrayHasKey('foo/bar', $replace);
                $that->assertArrayHasKey('foo/baz', $replace);
                $that->assertArrayHasKey('foo/xyzzy', $replace);

                $that->assertTrue($replace['foo/bar'] instanceof Link);
                $that->assertTrue($replace['foo/baz'] instanceof Link);
                $that->assertTrue($replace['foo/xyzzy'] instanceof Link);

                $that->assertEquals(
                    '1.2.3.4',
                    $replace['foo/bar']->getPrettyConstraint()
                );
                $that->assertEquals(
                    '1.2.3.4',
                    $replace['foo/baz']->getPrettyConstraint()
                );
                $that->assertEquals(
                    '~1.0',
                    $replace['foo/xyzzy']->getPrettyConstraint()
                );
            }
        );

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);
        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * Test replace link with self.version as version constraint.
     *
     * @param bool $fireInit Fire the INIT event?
     * @dataProvider provideFireInit
     */
    public function testSelfVersionNoRootVersion($fireInit)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setReplaces(Argument::type('array'))->will(
            function ($args) use ($that) {
                $replace = $args[0];
                $that->assertEquals(3, count($replace));

                $that->assertArrayHasKey('foo/bar', $replace);
                $that->assertArrayHasKey('foo/baz', $replace);
                $that->assertArrayHasKey('foo/xyzzy', $replace);

                $that->assertTrue($replace['foo/bar'] instanceof Link);
                $that->assertTrue($replace['foo/baz'] instanceof Link);
                $that->assertTrue($replace['foo/xyzzy'] instanceof Link);

                $that->assertEquals(
                    '~8.0',
                    $replace['foo/bar']->getPrettyConstraint()
                );
                $that->assertEquals(
                    '~8.0',
                    $replace['foo/baz']->getPrettyConstraint()
                );
                $that->assertEquals(
                    '~1.0',
                    $replace['foo/xyzzy']->getPrettyConstraint()
                );
            }
        );

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir, $fireInit);
        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * Given a root package with minimum-stability=beta
     *   and a required stable package
     *   and an include with a stability=dev require for the same package
     *   and a stability=stable require for another package
     * When the plugin is run
     * Then the first package should require stability=dev
     *   amd the second package should not specify a minimum stability.
     *
     * @return void
     */
    public function testMergedStabilityFlagsRespectsMinimumStability()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        // The root package declares a stable package
        $root->getStabilityFlags()->willReturn(array(
            'wikimedia/composer-merge-plugin' => BasePackage::STABILITY_STABLE,
        ))->shouldBeCalled();

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(2, count($requires));
                $that->assertArrayHasKey('wikimedia/composer-merge-plugin', $requires);
                $that->assertArrayHasKey('robbytaylor/test', $requires);
            }
        );

        $root->setStabilityFlags(Argument::type('array'))->will(
            function ($args) use ($that, &$expects) {
                $that->assertSame(
                    array(
                        'wikimedia/composer-merge-plugin' => BasePackage::STABILITY_DEV,
                    ),
                    $args[0]
                );
            }
        );
        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);
    }


    /**
     * Given a root package with merge-dev=false
     *   and an include with require-dev and autoload-dev sections
     * When the plugin is run
     * Then the -dev sections are not merged
     */
    public function testMergeDevFalse()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");
        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(2, count($requires));
                $that->assertArrayHasKey('wikimedia/composer-merge-plugin', $requires);
                $that->assertArrayHasKey('acme/foo', $requires);
            }
        )->shouldBeCalled();
        $root->setDevRequires(Argument::type('array'))->shouldNotBeCalled();
        $root->setRepositories(Argument::type('array'))->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);
        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * @expectedException \Wikimedia\Composer\Merge\MissingFileException
     */
    public function testMissingRequireThrowsException()
    {
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");
        $root->getRequires()->shouldNotBeCalled();
        $root->getDevRequires()->shouldNotBeCalled();
        $root->setReferences(Argument::type('array'))->shouldNotBeCalled();
        $this->triggerPlugin($root->reveal(), $dir);
    }


    public function testRequire()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);

        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(1, count($requires));
                $that->assertArrayHasKey('monolog/monolog', $requires);
            }
        );

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }


    /**
     * @param bool $fireInit Fire the INIT event?
     * @dataProvider provideFireInit
     */
    public function testVersionConstraintWithRevision($fireInit)
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args, $root) {
                $root->getRequires()->willReturn($args[0]);
            }
        )->shouldBeCalled();

        $root->setDevRequires(Argument::type('array'))->will(
            function ($args, $root) {
                $root->getDevRequires()->willReturn($args[0]);
            }
        )->shouldBeCalled();

        $checkRefsWithDev = function ($args) use ($that) {
            $references = $args[0];
            $that->assertEquals(3, count($references));

            $that->assertArrayHasKey('foo/bar', $references);
            $that->assertArrayHasKey('monolog/monolog', $references);
            $that->assertArrayHasKey('foo/baz', $references);

            $that->assertSame($references['foo/bar'], '1234567');
            $that->assertSame($references['monolog/monolog'], 'cb641a8');
            $that->assertSame($references['foo/baz'], 'abc1234');
        };

        if ($fireInit) {
            $checkRefs = function ($args) use ($that, $root, $checkRefsWithDev) {
                $references = $args[0];
                $that->assertEquals(2, count($references));

                $that->assertArrayHasKey('foo/bar', $references);
                $that->assertArrayHasKey('monolog/monolog', $references);

                $that->assertSame($references['foo/bar'], '1234567');
                $that->assertSame($references['monolog/monolog'], 'cb641a8');

                // onInit does parse without require-dev, so this is called a
                // second time when onInstallUpdateOrDump() fires with the dev
                // section parsed as well.
                $root->setReferences(Argument::type('array'))->will($checkRefsWithDev);
            };
        } else {
            $checkRefs = $checkRefsWithDev;
        }

        $root->setReferences(Argument::type('array'))->will($checkRefs);
        $this->triggerPlugin($root->reveal(), $dir, $fireInit);
    }

    /**
     * Generic provider for tests that should be tried with and without an
     * INIT event.
     */
    public function provideFireInit()
    {
        return array(
            "with INIT event" => array(true),
            "without INIT event" => array(true),
        );
    }

    /**
     * @param RootPackage $package
     * @param string $directory Working directory for composer run
     * @param bool $fireInit Should the init event should be triggered?
     * @return array Constrains added by MergePlugin::onDependencySolve
     */
    protected function triggerPlugin($package, $directory, $fireInit = false)
    {
        chdir($directory);
        $this->composer->getPackage()->willReturn($package);

        if ($fireInit) {
            $init = new \Composer\EventDispatcher\Event(
                MergePlugin::COMPAT_PLUGINEVENTS_INIT
            );
            $this->fixture->onInit($init);
        }

        $event = new Event(
            ScriptEvents::PRE_INSTALL_CMD,
            $this->composer->reveal(),
            $this->io->reveal(),
            true, //dev mode
            array(),
            array()
        );
        $this->fixture->onInstallUpdateOrDump($event);

        $requestInstalls = array();
        $request = $this->prophesize('Composer\DependencyResolver\Request');
        $request->install(Argument::any(), Argument::any())->will(
            function ($args) use (&$requestInstalls) {
                $requestInstalls[] = $args;
            }
        );

        $event = new InstallerEvent(
            InstallerEvents::PRE_DEPENDENCIES_SOLVING,
            $this->composer->reveal(),
            $this->io->reveal(),
            true, //dev mode
            $this->prophesize('Composer\DependencyResolver\PolicyInterface')->reveal(),
            $this->prophesize('Composer\DependencyResolver\Pool')->reveal(),
            $this->prophesize('Composer\Repository\CompositeRepository')->reveal(),
            $request->reveal(),
            array()
        );

        $this->fixture->onDependencySolve($event);

        $event = new Event(
            ScriptEvents::PRE_AUTOLOAD_DUMP,
            $this->composer->reveal(),
            $this->io->reveal(),
            true, //dev mode
            array(),
            array( 'optimize' => true )
        );
        $this->fixture->onInstallUpdateOrDump($event);

        $event = new Event(
            ScriptEvents::POST_INSTALL_CMD,
            $this->composer->reveal(),
            $this->io->reveal(),
            true, //dev mode
            array(),
            array()
        );
        $this->fixture->onPostInstallOrUpdate($event);

        return $requestInstalls;
    }

    /**
     * @param string $subdir
     * @return string
     */
    protected function fixtureDir($subdir)
    {
        return __DIR__ . "/fixtures/{$subdir}";
    }

    /**
     * @param string $file
     * @return ObjectProphecy
     */
    protected function rootFromJson($file)
    {
        $that = $this;
        $json = json_decode(file_get_contents($file), true);

        $data = array_merge(
            array(
                'name' => '__root__',
                'version' => '1.0.0',
                'repositories' => array(),
                'require' => array(),
                'require-dev' => array(),
                'conflict' => array(),
                'replace' => array(),
                'provide' => array(),
                'suggest' => array(),
                'extra' => array(),
                'scripts' => array(),
                'autoload' => array(),
                'autoload-dev' => array(),
                'minimum-stability' => 'stable',
            ),
            $json
        );

        // Convert packages to proper links
        $vp = new VersionParser();
        foreach (array(
            'require', 'require-dev', 'conflict', 'replace', 'provide'
        ) as $type) {
            $lt = BasePackage::$supportedLinkTypes[$type];
            foreach ($data[$type] as $k => $v) {
                unset($data[$type][$k]);
                if ($v === 'self.version') {
                    $v = $data['version'];
                }
                $data[$type][strtolower($k)] = new Link(
                    $data['name'],
                    $k,
                    $vp->parseConstraints($v),
                    $lt['description'],
                    $v
                );
            }
        }

        $root = $this->prophesize('Composer\Package\RootPackage');
        $root->getVersion()->willReturn($vp->normalize($data['version']));
        $root->getPrettyVersion()->willReturn($data['version']);
        $root->getMinimumStability()->willReturn($data['minimum-stability']);
        $root->getRequires()->willReturn($data['require'])->shouldBeCalled();
        $root->getDevRequires()->willReturn($data['require-dev'])->shouldBeCalled();
        $root->getRepositories()->willReturn($data['repositories']);
        $root->getConflicts()->willReturn($data['conflict']);
        $root->getReplaces()->willReturn($data['replace']);
        $root->getProvides()->willReturn($data['provide']);
        $root->getSuggests()->willReturn($data['suggest']);
        $root->getExtra()->willReturn($data['extra'])->shouldBeCalled();
        $root->getScripts()->willReturn($data['scripts']);
        $root->getAutoload()->willReturn($data['autoload']);
        $root->getDevAutoload()->willReturn($data['autoload-dev']);

        $root->getStabilityFlags()->willReturn(array());
        $root->setStabilityFlags(Argument::type('array'))->will(
            function ($args) use ($that) {
                foreach ($args[0] as $key => $value) {
                    $that->assertContains($value, BasePackage::$stabilities);
                }
            }
        );
        $root->setReferences(Argument::type('array'))->shouldBeCalled();

        return $root;
    }

    /**
     * Wrap a package in a mocked alias.
     *
     * @param object $root
     * @return ObjectProphecy
     */
    protected function makeAliasFor($root)
    {
        $alias = $this->prophesize('Composer\Package\RootAliasPackage');
        $alias->getAliasOf()->willReturn($root);
        $alias->getVersion()->will(function () use ($root) {
            return $root->getVersion();
        });
        $alias->getPrettyVersion()->will(function () use ($root) {
            return $root->getPrettyVersion();
        });
        $alias->getMinimumStability()->will(function () use ($root) {
            return $root->getMinimumStability();
        });
        $alias->getAliases()->will(function () use ($root) {
            return $root->getAliases();
        });
        $alias->getAutoload()->will(function () use ($root) {
            return $root->getAutoload();
        });
        $alias->getConflicts()->will(function () use ($root) {
            return $root->getConflicts();
        });
        $alias->getDevAutoload()->will(function () use ($root) {
            return $root->getDevAutoload();
        });
        $alias->getDevRequires()->will(function () use ($root) {
            return $root->getDevRequires();
        });
        $alias->getExtra()->will(function () use ($root) {
            return $root->getExtra();
        });
        $alias->getProvides()->will(function () use ($root) {
            return $root->getProvides();
        });
        $alias->getReferences()->will(function () use ($root) {
            return $root->getReferences();
        });
        $alias->getReplaces()->will(function () use ($root) {
            return $root->getReplaces();
        });
        $alias->getRepositories()->will(function () use ($root) {
            return $root->getRepositories();
        });
        $alias->getRequires()->will(function () use ($root) {
            return $root->getRequires();
        });
        $alias->getStabilityFlags()->will(function () use ($root) {
            return $root->getStabilityFlags();
        });
        $alias->getSuggests()->will(function () use ($root) {
            return $root->getSuggests();
        });
        return $alias;
    }

    /**
     * @return PluginState
     */
    protected function getState()
    {
        $state = new ReflectionProperty(
            get_class($this->fixture),
            'state'
        );
        $state->setAccessible(true);
        return $state->getValue($this->fixture);
    }
}
// vim:sw=4:ts=4:sts=4:et:
