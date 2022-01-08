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

use SoureCode\Component\Menu\Model\Menu;
use SoureCode\Component\Menu\Model\MenuInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuBuilder extends AbstractBuilder implements MenuBuilderInterface
{
    /**
     * @var list<MenuItemBuilderInterface>
     */
    protected array $items = [];

    protected ?string $label = null;

    protected ?string $template = null;

    protected string $name;

    protected string|array|null $grant = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addItem(string $label): MenuItemBuilderInterface
    {
        $menuItemBuilder = new MenuItemBuilder($this, $label);

        $this->items[] = $menuItemBuilder;

        return $menuItemBuilder;
    }

    public function addLinkItem(string $label, string $link): LinkMenuItemBuilderInterface
    {
        $menuLinkItemBuilder = new LinkMenuItemBuilder($this, $label, $link);

        $this->items[] = $menuLinkItemBuilder;

        return $menuLinkItemBuilder;
    }

    public function addRouteItem(
        string $label,
        string $routeName,
        array $routeParameters = []
    ): RouteMenuItemBuilderInterface {
        $menuRouteItemBuilder = new RouteMenuItemBuilder($this, $label, $routeName, $routeParameters);

        $this->items[] = $menuRouteItemBuilder;

        return $menuRouteItemBuilder;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    protected function build(): MenuInterface
    {
        $menu = new Menu();

        $menu->setName($this->name);
        $menu->setLabel($this->label);
        $menu->setTemplate($this->template);
        $menu->setGrant($this->grant);

        foreach ($this->items as $item) {
            if (is_a($item, MenuItemBuilderInterface::class)) {
                /**
                 * @var AbstractBuilder $item
                 */
                $menuItem = $item->build();

                $menu->addMenuItem($menuItem);
            }
        }

        return $menu;
    }

    public function setGrant(array|string $grant): self
    {
        $this->grant = $grant;

        return $this;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }
}
