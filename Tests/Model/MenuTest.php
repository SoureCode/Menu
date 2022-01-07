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

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuTest extends TestCase
{
    public function testCreateView(): void
    {
        $menu = new Menu();
        $menu->setName('foo');
        $menu->setLabel('bar');

        $item1 = new LinkMenuItem();
        $item1->setLabel('test1');

        $item2 = new LinkMenuItem();
        $item2->setLabel('test2');

        $menu->addMenuItem($item1);
        $menu->addMenuItem($item2);

        $view = $menu->createView();

        $this->assertEquals([
            'name' => 'foo',
            'label' => 'bar',
            'menu' => $menu,
        ], $view->vars);

        $this->assertEquals([
            $item1->createView(),
            $item2->createView(),
        ], $view->items);
    }

    public function testGetAddRemoveItem(): void
    {
        $menu = new Menu();

        $item = new LinkMenuItem();
        $item->setLabel('test1');

        $menu->addMenuItem($item);

        $this->assertCount(1, $menu->getMenuItems());
        $this->assertEquals($item, $menu->getMenuItems()->get(0));

        $menu->removeMenuItem($item);

        $this->assertCount(0, $menu->getMenuItems());
    }

    public function testGetSetLabel(): void
    {
        $menu = new Menu();

        $menu->setLabel('Main menu');

        $this->assertEquals('Main menu', $menu->getLabel());
    }

    public function testGetSetName(): void
    {
        $menu = new Menu();

        $menu->setName('test');

        $this->assertEquals('test', $menu->getName());
    }

    public function testItemsKeepOrderAfterItemRemoval(): void
    {
        $menu = new Menu();

        $item1 = new LinkMenuItem();
        $item1->setLabel('test1');

        $item2 = new LinkMenuItem();
        $item2->setLabel('test2');

        $item3 = new LinkMenuItem();
        $item3->setLabel('test3');

        $menu->addMenuItem($item1);
        $menu->addMenuItem($item2);

        $this->assertEquals($item1, $menu->getMenuItems()->get(0));
        $this->assertEquals($item2, $menu->getMenuItems()->get(1));

        $menu->removeMenuItem($item1);

        $menu->addMenuItem($item3);

        $this->assertEquals($item2, $menu->getMenuItems()->get(1));
        $this->assertEquals($item3, $menu->getMenuItems()->get(2));
    }
}
