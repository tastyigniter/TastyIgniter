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
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\Installer\InstallerEvent;
use Composer\Installer\InstallerEvents;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\BasePackage;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Script\CommandEvent;
use Composer\Script\ScriptEvents;
use Prophecy\Argument;
use \ReflectionMethod;

/**
 * @covers Wikimedia\Composer\MergePlugin
 */
class MergePluginTest extends \Prophecy\PhpUnit\ProphecyTestCase
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
        $this->assertEquals(7, count($subscriptions));
        $this->assertArrayHasKey(
            InstallerEvents::PRE_DEPENDENCIES_SOLVING,
            $subscriptions
        );
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

        $root->getDevRequires()->shouldNotBeCalled();
        $root->getRepositories()->shouldNotBeCalled();
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


        $root->getDevRequires()->shouldNotBeCalled();
        $root->getRepositories()->shouldNotBeCalled();
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


        $root->getDevRequires()->shouldNotBeCalled();
        $root->getRepositories()->shouldNotBeCalled();
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
     */
    public function testOneMergeWithConflicts()
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
        );

        $root->getRepositories()->shouldNotBeCalled();
        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(1, count($extraInstalls));
        $this->assertEquals('monolog/monolog', $extraInstalls[0][0]);
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
        $repoManager->addRepository(Argument::any())->will(
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

        $root->getDevRequires()->shouldNotBeCalled();
        $root->setDevRequires()->shouldNotBeCalled();

        $root->setRepositories(Argument::type('array'))->will(
            function ($args) use ($that) {
                $repos = $args[0];
                $that->assertEquals(1, count($repos));
            }
        );

        $root->getSuggests()->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * Given a root package
     *   and a composer.local.json with required packages
     * When the plugin is run
     * Then the root package should be updated with stability flags.
     */
    public function testUpdateStabilityFlags()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->setRequires(Argument::type('array'))->will(
            function ($args) use ($that) {
                $requires = $args[0];
                $that->assertEquals(4, count($requires));
                $that->assertArrayHasKey('test/foo', $requires);
                $that->assertArrayHasKey('test/bar', $requires);
                $that->assertArrayHasKey('test/baz', $requires);
                $that->assertArrayHasKey('test/xyzzy', $requires);
            }
        );

        $root->getDevRequires()->shouldNotBeCalled();
        $root->setDevRequires(Argument::any())->shouldNotBeCalled();

        $root->getRepositories()->shouldNotBeCalled();
        $root->setRepositories(Argument::any())->shouldNotBeCalled();

        $root->getSuggests()->shouldNotBeCalled();
        $root->setSuggests(Argument::any())->shouldNotBeCalled();

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    public function testMergedAutoload()
    {
        $that = $this;
        $dir = $this->fixtureDir(__FUNCTION__);
        $root = $this->rootFromJson("{$dir}/composer.json");

        $root->getAutoload()->shouldBeCalled();
        $root->getRequires()->shouldNotBeCalled();
        $root->setAutoload(Argument::type('array'))->will(
            function ($args) use ($that) {
                $that->assertEquals(
                    array(
                        'psr-4' => array(
                            'Kittens\\' => array( 'everywhere/', 'extensions/Foo/a/', 'extensions/Foo/b/' ),
                            'Cats\\' => 'extensions/Foo/src/'
                        ),
                        'psr-0' => array(
                            'UniqueGlobalClass' => 'extensions/Foo/',
                            '' => 'extensions/Foo/fallback/'
                        ),
                        'files' => array( 'extensions/Foo/SemanticMediaWiki.php' ),
                        'classmap' => array( 'extensions/Foo/SemanticMediaWiki.hooks.php', 'extensions/Foo/includes/' ),
                    ),
                    $args[0]
                );
            }
        );

        $extraInstalls = $this->triggerPlugin($root->reveal(), $dir);

        $this->assertEquals(0, count($extraInstalls));
    }

    /**
     * @dataProvider provideOnPostPackageInstall
     */
    public function testOnPostPackageInstall($package, $first)
    {
        $operation = new InstallOperation(
            new Package($package, '1.2.3.4', '1.2.3')
        );
        $event = $this->prophesize('Composer\Installer\PackageEvent');
        $event->getOperation()->willReturn($operation)->shouldBeCalled();
        $this->fixture->onPostPackageInstall($event->reveal());
        $this->assertEquals($first, $this->fixture->isFirstInstall());
    }

    public function provideOnPostPackageInstall()
    {
        return array(
            array(MergePlugin::PACKAGE_NAME, true),
            array('foo/bar', false),
        );
    }

    /**
     * Given a root package with a branch alias
     * When the plugin is run
     * Then the root package will be unwrapped from the alias.
     */
    public function testHasBranchAlias()
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
                $that->assertArrayHasKey('php', $requires);
            }
        );
        $root = $root->reveal();

        $alias = $this->prophesize('Composer\Package\RootAliasPackage');
        $alias->getAliasOf()->willReturn($root)->shouldBeCalled();

        $this->triggerPlugin($alias->reveal(), $dir);

        $getRootPackage = new ReflectionMethod(
            get_class($this->fixture),
            'getRootPackage'
        );
        $getRootPackage->setAccessible(true);
        $this->assertEquals($root, $getRootPackage->invoke($this->fixture));
    }

    /**
     * @param RootPackage $package
     * @param string $directory Working directory for composer run
     * @return array Constrains added by MergePlugin::onDependencySolve
     */
    protected function triggerPlugin($package, $directory)
    {
        chdir($directory);
        $this->composer->getPackage()->willReturn($package);

        $event = new CommandEvent(
            ScriptEvents::PRE_INSTALL_CMD,
            $this->composer->reveal(),
            $this->io->reveal(),
            true, //dev mode
            array(),
            array()
        );
        $this->fixture->onInstallOrUpdate($event);

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
                'repositories' => array(),
                'require' => array(),
                'require-dev' => array(),
                'suggest' => array(),
                'extra' => array(),
                'autoload' => array(),
            ),
            $json
        );

        $root = $this->prophesize('Composer\Package\RootPackage');
        $root->getRequires()->willReturn($data['require'])->shouldBeCalled();
        $root->getDevRequires()->willReturn($data['require-dev']);
        $root->getRepositories()->willReturn($data['repositories']);
        $root->getSuggests()->willReturn($data['suggest']);
        $root->getExtra()->willReturn($data['extra'])->shouldBeCalled();
        $root->getAutoload()->willReturn($data['autoload']);

        $root->getStabilityFlags()->willReturn(array());
        $root->setStabilityFlags(Argument::type('array'))->will(
            function ($args) use ($that) {
                foreach ($args[0] as $key => $value) {
                    $that->assertContains($value, BasePackage::$stabilities);
                }
            }
        );

        return $root;
    }
}
// vim:sw=4:ts=4:sts=4:et:
