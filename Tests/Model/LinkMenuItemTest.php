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

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class LinkMenuItemTest extends TestCase
{
    public function testCreateView(): void
    {
        $link = 'https://example.com';

        $menuItem = new LinkMenuItem();
        $menuItem->setLink($link);

        $view = $menuItem->createView();

        $this->assertEquals([
            'label' => null,
            'icon' => null,
            'grant' => null,
            'item' => $menuItem,
            'menu' => null,
            'link' => 'https://example.com',
        ], $view->vars);
    }

    public function testGetSetLink(): void
    {
        $link = 'https://example.com';

        $menuItem = new LinkMenuItem();
        $menuItem->setLink($link);

        $this->assertEquals($link, $menuItem->getLink());
    }
}
