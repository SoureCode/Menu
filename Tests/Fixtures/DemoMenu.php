<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Tests\Fixtures;

use SoureCode\Component\Menu\AbstractMenu;
use SoureCode\Component\Menu\Builder\MenuBuilderInterface;

class DemoMenu extends AbstractMenu
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function buildMenu(MenuBuilderInterface $menuBuilder, array $context = []): void
    {
        $menuBuilder
            ->setLabel('Demo Menu')
            ->addItem('Websites')
            ->addLinkItem('Google', 'https://www.google.de')->end()
            ->addLinkItem('Yahoo', 'https://www.yahoo.de')->end()
            ->addLinkItem('Bing', 'https://www.bing.de')->end()
            ->addLinkItem('DuckDuckGo', 'https://www.duckduckgo.de')->end()
            ;
    }
}
