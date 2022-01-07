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
use SoureCode\Component\Menu\Model\MenuItemInterface;
use SoureCode\Component\Menu\Model\RouteMenuItem;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class RouteMenuItemBuilder extends MenuItemBuilder implements RouteMenuItemBuilderInterface
{
    private string $routeName;

    private array $routeParameters;

    public function __construct(
        MenuBuilderInterface $menuBuilder,
        string $label,
        string $routeName,
        array $routeParameters = [],
        ?MenuItemBuilderInterface $menuItemBuilder = null
    ) {
        parent::__construct($menuBuilder, $label, $menuItemBuilder);

        $this->routeName = $routeName;
        $this->routeParameters = $routeParameters;
    }

    public function addItem(string $label): MenuItemBuilderInterface
    {
        throw new LogicException('Can not add item to a route item.');
    }

    public function setRouteName(string $routeName): RouteMenuItemBuilderInterface
    {
        $this->routeName = $routeName;

        return $this;
    }

    public function setRouteParameters(array $routeParameters): RouteMenuItemBuilderInterface
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    public function addRouteParameter(string $key, mixed $value): RouteMenuItemBuilderInterface
    {
        $this->routeParameters[$key] = $value;

        return $this;
    }

    protected function build(): MenuItemInterface
    {
        $menuItem = new RouteMenuItem();

        $menuItem->setLabel($this->label);
        $menuItem->setGrant($this->grant);
        $menuItem->setIcon($this->icon);
        $menuItem->setRouteName($this->routeName);
        $menuItem->setRouteParameters($this->routeParameters);

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
