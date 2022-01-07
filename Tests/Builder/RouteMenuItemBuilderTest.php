<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Tests\Builder;

use PHPUnit\Framework\TestCase;
use SoureCode\Component\Menu\Builder\Director;
use SoureCode\Component\Menu\Builder\MenuBuilder;
use SoureCode\Component\Menu\Model\MenuInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class RouteMenuItemBuilderTest extends TestCase
{
    public function testAddItemThrowsException(): void
    {
        $this->expectException(\LogicException::class);

        $menuBuilder = new MenuBuilder('test');
        $routeMenuItemBuilder = $menuBuilder->addRouteItem('foo', 'foo_bar');

        $routeMenuItemBuilder->addItem('bar');
    }

    public function testAddLinkItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $routeMenuItemBuilder = $menuBuilder->addRouteItem('foo', 'foo_bar');
        $director = new Director($menuBuilder);

        $routeMenuItemBuilder->addLinkItem('bar', 'https://example.com/bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('https://example.com/bar', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getLink());
    }

    public function testAddRouteItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $routeMenuItemBuilder = $menuBuilder->addRouteItem('foo', 'foo_bar');
        $director = new Director($menuBuilder);

        $routeMenuItemBuilder->addRouteItem('bar', 'bar_route');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('bar_route', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getRouteName());
    }

    public function testSetRouteNameAndSetRouteParameters(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $routeMenuItemBuilder = $menuBuilder->addRouteItem('foo', 'bar_foo', ['foo' => 'bar']);
        $director = new Director($menuBuilder);

        $routeMenuItemBuilder->setRouteName('foo_bar');
        $routeMenuItemBuilder->setRouteParameters(['foo' => 'bar', 'bar' => 'foo']);
        $routeMenuItemBuilder->addRouteParameter('lorem', 'ipsum');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('foo_bar', $menu->getMenuItems()->get(0)->getRouteName());
        $this->assertEquals(
            ['foo' => 'bar', 'bar' => 'foo', 'lorem' => 'ipsum'],
            $menu->getMenuItems()->get(0)->getRouteParameters()
        );
    }
}
