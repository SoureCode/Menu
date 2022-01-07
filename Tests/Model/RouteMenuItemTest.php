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
use SoureCode\Component\Menu\Model\RouteMenuItem;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class RouteMenuItemTest extends TestCase
{
    public function testGetSetRouteName(): void
    {
        $item = new RouteMenuItem();

        $item->setRouteName('test');

        $this->assertEquals('test', $item->getRouteName());
    }

    public function testGetSetRouteParameters(): void
    {
        $item = new RouteMenuItem();

        $item->setRouteParameters(['foo' => 'test']);

        $this->assertEquals(['foo' => 'test'], $item->getRouteParameters());
    }

    public function testCreateView(): void
    {
        $item = new RouteMenuItem();

        $item->setRouteName('test');
        $item->setRouteParameters(['foo' => 'test']);

        $view = $item->createView();

        $this->assertEquals([
            'label' => null,
            'icon' => null,
            'grant' => null,
            'item' => $item,
            'menu' => null,
            'routeName' => 'test',
            'routeParameters' => [
                'foo' => 'test',
            ],
        ], $view->vars);
    }
}
