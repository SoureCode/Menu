<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Tests;

use PHPUnit\Framework\TestCase;
use SoureCode\Component\Menu\MenuRegistry;
use SoureCode\Component\Menu\Model\MenuItemInterface;
use SoureCode\Component\Menu\Tests\Fixtures\DemoMenu;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuRegistryTest extends TestCase
{
    public function testAdd(): void
    {
        $menuRegistry = new MenuRegistry();
        $name = 'test';
        $menu = new DemoMenu($name);

        $menuRegistry->add($menu);

        $this->assertTrue($menuRegistry->has($name));
    }

    public function testAddOverrides(): void
    {
        $menuRegistry = new MenuRegistry();
        $name = 'test';
        $menu1 = new DemoMenu($name);
        $menu2 = new DemoMenu($name);

        $menuRegistry->add($menu1);
        $menuRegistry->add($menu2);

        $this->assertTrue($menuRegistry->has($name));
        $this->assertSame($menu2, $menuRegistry->get($name));
    }

    public function testGet()
    {
        $menuRegistry = new MenuRegistry();
        $name = 'test';
        $menu = new DemoMenu($name);

        $menuRegistry->add($menu);

        $this->assertSame($menu, $menuRegistry->get($name));
    }

    public function testGetThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Menu "test" does not exist.');

        $menuRegistry = new MenuRegistry();
        $menuRegistry->get('test');
    }

    public function testBuild(): void
    {
        $menuRegistry = new MenuRegistry();
        $menu = new DemoMenu('demo');

        $menuRegistry->add($menu);
        $actual = $menuRegistry->build('demo');

        $this->assertSame('demo', $actual->getName());
        $this->assertSame('Demo Menu', $actual->getLabel());
        $this->assertCount(1, $actual->getMenuItems());

        $items = $actual->getMenuItems();
        /**
         * @var MenuItemInterface $first
         */
        $first = $items->first();

        $this->assertSame('Websites', $first->getLabel());

        $websiteItems = $first->getMenuItems();

        $this->assertCount(4, $websiteItems);
        $this->assertSame('Google', $websiteItems->get(0)->getLabel());
        $this->assertSame('Yahoo', $websiteItems->get(1)->getLabel());
        $this->assertSame('Bing', $websiteItems->get(2)->getLabel());
        $this->assertSame('DuckDuckGo', $websiteItems->get(3)->getLabel());
    }
}
