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
use SoureCode\Component\Menu\Model\MenuItem;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuItemTest extends TestCase
{
    public function testAddRemoveGetItem(): void
    {
        $item = new MenuItem();
        $child = new MenuItem();

        $this->assertCount(0, $item->getMenuItems());

        $item->addMenuItem($child);

        $this->assertCount(1, $item->getMenuItems());
        $this->assertEquals($child, $item->getMenuItems()->get(0));

        $item->removeMenuItem($child);

        $this->assertCount(0, $item->getMenuItems());
    }

    public function testCreateView(): void
    {
        $menu = new Menu();

        $item = new MenuItem();
        $item->setLabel('test');
        $item->setIcon('fa fa-test');
        $item->setGrant('ROLE_ADMIN');
        $item->setMenu($menu);

        $subItem = new MenuItem();
        $subItem->setLabel('foo');
        $subItem->setIcon('fa fa-bar');
        $subItem->setGrant('ROLE_USER');

        $item->addMenuItem($subItem);

        $view = $item->createView();

        $this->assertEquals([
            'label' => 'test',
            'icon' => 'fa fa-test',
            'template' => null,
            'grant' => 'ROLE_ADMIN',
            'item' => $item,
            'menu' => $menu,
        ], $view->vars);

        $this->assertEquals([
            $subItem->createView($view),
        ], $view->items);
    }

    public function testGetSetLabel(): void
    {
        $item = new MenuItem();

        $this->assertNull($item->getLabel());

        $item->setLabel('label');

        $this->assertEquals('label', $item->getLabel());
    }

    public function testGetSetMenu(): void
    {
        $item = new MenuItem();
        $menu = new Menu();

        $this->assertNull($item->getMenu());

        $item->setMenu($menu);

        $this->assertEquals($menu, $item->getMenu());
    }

    public function testGetSetParent(): void
    {
        $item = new MenuItem();
        $parent = new MenuItem();

        $this->assertNull($item->getParent());

        $item->setParent($parent);

        $this->assertEquals($parent, $item->getParent());
    }

    public function testGetSetTemplate(): void
    {
        $item = new MenuItem();

        $this->assertNull($item->getTemplate());

        $item->setTemplate('template');

        $this->assertEquals('template', $item->getTemplate());
    }

    public function testHasMenuItems(): void
    {
        $item = new MenuItem();

        $this->assertFalse($item->hasMenuItems());

        $item->addMenuItem(new MenuItem());

        $this->assertTrue($item->hasMenuItems());
    }

    public function testItemsKeepOrderAfterItemRemoval(): void
    {
        $item = new MenuItem();

        $item1 = new LinkMenuItem();
        $item1->setLabel('test1');

        $item2 = new LinkMenuItem();
        $item2->setLabel('test2');

        $item3 = new LinkMenuItem();
        $item3->setLabel('test3');

        $item->addMenuItem($item1);
        $item->addMenuItem($item2);

        $this->assertEquals($item1, $item->getMenuItems()->get(0));
        $this->assertEquals($item2, $item->getMenuItems()->get(1));

        $item->removeMenuItem($item1);

        $item->addMenuItem($item3);

        $this->assertEquals($item2, $item->getMenuItems()->get(1));
        $this->assertEquals($item3, $item->getMenuItems()->get(2));
    }
}
