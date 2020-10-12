<?php

namespace Tests\Unit\Classes;

use Tests\TestCase;

class NavigationTest extends TestCase
{
    public function testRegisterNavItems()
    {
        $manager = $this->app->make('admin.menu');
        $items = $manager->getNavItems();
        $this->assertArrayNotHasKey('dashboard', $items);

        $manager->registerNavItems([
            'dashboard' => [
                'class' => 'dashboard admin',
                'href' => 'http://dashboard.tld',
                'icon' => 'fa-dashboard',
                'title' => 'Dashboard',
                'priority' => 999,
            ],
        ]);

        $items = $manager->getNavItems();
        $this->assertArrayHasKey('dashboard', $items);

        $item = $items['dashboard'];
        $this->assertArrayHasKey('code', $item);
        $this->assertArrayHasKey('class', $item);
        $this->assertArrayHasKey('href', $item);
        $this->assertArrayHasKey('icon', $item);
        $this->assertArrayHasKey('title', $item);
        $this->assertArrayHasKey('child', $item);
        $this->assertArrayHasKey('priority', $item);
        $this->assertArrayHasKey('permission', $item);

        $this->assertEquals('dashboard', $item['code']);
        $this->assertEquals('Dashboard', $item['title']);
        $this->assertEquals('fa-dashboard', $item['icon']);
        $this->assertEquals('http://dashboard.tld', $item['href']);
        $this->assertEquals(999, $item['priority']);
    }

}
