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
class MenuItemBuilderTest extends TestCase
{
    public function testSetLabel(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->setLabel('bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('bar', $menu->getMenuItems()->get(0)->getLabel());
    }

    public function testAddItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $lowest = $menuItemBuilder->addItem('bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertCount(1, $menu->getMenuItems());
        $this->assertEquals('foo', $menu->getMenuItems()->get(0)->getLabel());
        $this->assertEquals('bar', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getLabel());
        $this->assertEquals($menuItemBuilder, $lowest->end());
        $this->assertEquals($menuBuilder, $lowest->root());
    }

    public function testSetTemplate(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->setTemplate('bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('bar', $menu->getMenuItems()->get(0)->getTemplate());
    }

    public function testAppendDivider(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->appendDivider();

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('foo', $menu->getMenuItems()->get(0)->getLabel());
        $this->assertTrue($menu->getMenuItems()->get(0)->getAppendDivider());
    }

    public function testAddLinkItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->addLinkItem('bar', 'https://example.com/bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('https://example.com/bar', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getLink());
    }

    public function testAddRouteItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->addRouteItem('bar', 'bar_route');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('bar_route', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getRouteName());
    }

    public function testSetGrant(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->setGrant('ROLE_FOO');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('ROLE_FOO', $menu->getMenuItems()->get(0)->getGrant());
    }

    public function testSetIcon(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $menuItemBuilder = $menuBuilder->addItem('foo');
        $director = new Director($menuBuilder);

        $menuItemBuilder->setIcon('fa-bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('fa-bar', $menu->getMenuItems()->get(0)->getIcon());
    }
}
