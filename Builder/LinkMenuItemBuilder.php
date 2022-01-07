<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Builder;

use LogicException;
use SoureCode\Component\Menu\Model\LinkMenuItem;
use SoureCode\Component\Menu\Model\MenuItemInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class LinkMenuItemBuilder extends MenuItemBuilder implements LinkMenuItemBuilderInterface
{
    private string $link;

    public function __construct(
        MenuBuilderInterface $menuBuilder,
        string $label,
        string $link,
        ?MenuItemBuilderInterface $menuItemBuilder = null
    ) {
        parent::__construct($menuBuilder, $label, $menuItemBuilder);

        $this->link = $link;
    }

    public function addItem(string $label): MenuItemBuilderInterface
    {
        throw new LogicException('Can not add item to a link item.');
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    protected function build(): MenuItemInterface
    {
        $menuItem = new LinkMenuItem();

        $menuItem->setGrant($this->grant);
        $menuItem->setIcon($this->icon);
        $menuItem->setLabel($this->label);
        $menuItem->setLink($this->link);

        foreach ($this->items as $item) {
            if (is_a($item, MenuItemBuilderInterface::class)) {
                /**
                 * @var AbstractBuilder $item
                 */
                $child = $item->build();

                $menuItem->addMenuItem($child);
            }
        }

        return $menuItem;
    }
}
