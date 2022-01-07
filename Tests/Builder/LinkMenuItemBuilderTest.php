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
class LinkMenuItemBuilderTest extends TestCase
{
    public function testSetLink(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $linkMenuItemBuilder = $menuBuilder->addLinkItem('foo', 'https://example.com');
        $director = new Director($menuBuilder);

        $linkMenuItemBuilder->setLink('https://example.com/foo');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('https://example.com/foo', $menu->getMenuItems()->get(0)->getLink());
    }

    public function testAddItemThrowsException(): void
    {
        $this->expectException(\LogicException::class);

        $menuBuilder = new MenuBuilder('test');
        $linkMenuItemBuilder = $menuBuilder->addLinkItem('foo', 'https://example.com');

        $linkMenuItemBuilder->addItem('bar');
    }

    public function testAddLinkItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $linkMenuItemBuilder = $menuBuilder->addLinkItem('foo', 'https://example.com');
        $director = new Director($menuBuilder);

        $linkMenuItemBuilder->addLinkItem('bar', 'https://example.com/bar');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('https://example.com/bar', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getLink());
    }

    public function testAddRouteItem(): void
    {
        $menuBuilder = new MenuBuilder('test');
        $linkMenuItemBuilder = $menuBuilder->addLinkItem('foo', 'https://example.com');
        $director = new Director($menuBuilder);

        $linkMenuItemBuilder->addRouteItem('bar', 'bar_route');

        /**
         * @var MenuInterface $menu
         */
        $menu = $director->build();

        $this->assertEquals('bar_route', $menu->getMenuItems()->get(0)->getMenuItems()->get(0)->getRouteName());
    }
}
