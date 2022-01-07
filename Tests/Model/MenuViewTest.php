<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Tests\Model;

use PHPUnit\Framework\TestCase;
use SoureCode\Component\Menu\Model\LinkMenuItem;
use SoureCode\Component\Menu\Model\Menu;
use SoureCode\Component\Menu\Model\MenuItemView;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuViewTest extends TestCase
{
    public function testVarsAreWriteAndReadable(): void
    {
        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $view = $menu->createView();

        $view->vars['name'] = 'test';

        $this->assertEquals('test', $view->vars['name']);
    }

    public function testOffsetGetReturnsMenuItemView(): void
    {
        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $menu->addMenuItem(new LinkMenuItem());

        $view = $menu->createView();

        $this->assertInstanceOf(MenuItemView::class, $view[0]);
    }

    public function testOffsetSetThrowsException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $menu->createView()[0] = new LinkMenuItem();
    }

    public function testOffsetExistsReturnsBoolean(): void
    {
        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $view = $menu->createView();

        $this->assertFalse(isset($view[0]));

        $menu->addMenuItem(new LinkMenuItem());

        $view = $menu->createView();

        $this->assertTrue(isset($view[0]));
    }

    public function testOffsetUnsetUnsetsItem(): void
    {
        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $menu->addMenuItem(new LinkMenuItem());

        $view = $menu->createView();

        $this->assertTrue(isset($view[0]));

        unset($view[0]);

        $this->assertFalse(isset($view[0]));
    }

    public function testCountReturnsAmount(): void
    {
        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $view = $menu->createView();
        $this->assertCount(0, $view);

        $menu->addMenuItem(new LinkMenuItem());

        $view = $menu->createView();
        $this->assertCount(1, $view);

        $menu->addMenuItem(new LinkMenuItem());

        $view = $menu->createView();
        $this->assertCount(2, $view);
    }

    public function testGetIteratorReturnsAnIterator(): void
    {
        $menu = new Menu();
        $menu->setName('test');
        $menu->setLabel('test');

        $view = $menu->createView();

        $this->assertInstanceOf(\Traversable::class, $view->getIterator());
    }
}
