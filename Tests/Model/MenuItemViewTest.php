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
use SoureCode\Component\Menu\Model\MenuItem;
use SoureCode\Component\Menu\Model\MenuItemView;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuItemViewTest extends TestCase
{
    public function testCountReturnsAmount(): void
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $view = $menuItem->createView();
        $this->assertCount(0, $view);

        $menuItem->addMenuItem(new LinkMenuItem());

        $view = $menuItem->createView();
        $this->assertCount(1, $view);

        $menuItem->addMenuItem(new LinkMenuItem());

        $view = $menuItem->createView();
        $this->assertCount(2, $view);
    }

    public function testGetIteratorReturnsAnIterator(): void
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $view = $menuItem->createView();

        $this->assertInstanceOf(\Traversable::class, $view->getIterator());
    }

    public function testOffsetExistsReturnsBoolean(): void
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $view = $menuItem->createView();

        $this->assertFalse(isset($view[0]));

        $menuItem->addMenuItem(new LinkMenuItem());

        $view = $menuItem->createView();

        $this->assertTrue(isset($view[0]));
    }

    public function testOffsetGetReturnsMenuItemView(): void
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $menuItem->addMenuItem(new LinkMenuItem());

        $view = $menuItem->createView();

        $this->assertInstanceOf(MenuItemView::class, $view[0]);
    }

    public function testOffsetSetThrowsException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $menuItem->createView()[0] = new LinkMenuItem();
    }

    public function testOffsetUnsetUnsetsItem(): void
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $menuItem->addMenuItem(new LinkMenuItem());

        $view = $menuItem->createView();

        $this->assertTrue(isset($view[0]));

        unset($view[0]);

        $this->assertFalse(isset($view[0]));
    }

    public function testVarsAreWriteAndReadable(): void
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel('test');

        $view = $menuItem->createView();

        $view->vars['name'] = 'test';

        $this->assertEquals('test', $view->vars['name']);
    }
}
