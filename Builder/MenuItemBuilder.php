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

use SoureCode\Component\Menu\Model\MenuItem;
use SoureCode\Component\Menu\Model\MenuItemInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuItemBuilder extends AbstractBuilder implements MenuItemBuilderInterface
{
    protected string|array|null $grant = null;

    protected ?string $icon = null;

    protected ?bool $appendDivider = null;

    protected ?string $template = null;

    /**
     * @var MenuItemBuilderInterface[]
     */
    protected array $items = [];

    protected string $label;

    protected MenuBuilderInterface $menuBuilder;

    protected ?MenuItemBuilderInterface $parentItemBuilder = null;

    public function __construct(
        MenuBuilderInterface $menuBuilder,
        string $label,
        ?MenuItemBuilderInterface $menuItemBuilder = null
    ) {
        $this->menuBuilder = $menuBuilder;
        $this->parentItemBuilder = $menuItemBuilder;
        $this->label = $label;
    }

    public function addItem(string $label): MenuItemBuilderInterface
    {
        $itemBuilder = new self($this->menuBuilder, $label, $this);

        $this->items[] = $itemBuilder;

        return $itemBuilder;
    }

    public function addLinkItem(string $label, string $link): LinkMenuItemBuilderInterface
    {
        $menuLinkItemBuilder = new LinkMenuItemBuilder($this->menuBuilder, $label, $link, $this);

        $this->items[] = $menuLinkItemBuilder;

        return $menuLinkItemBuilder;
    }

    public function addRouteItem(
        string $label,
        string $routeName,
        array $routeParameters = []
    ): RouteMenuItemBuilderInterface {
        $menuRouteItemBuilder = new RouteMenuItemBuilder(
            $this->menuBuilder, $label, $routeName, $routeParameters, $this
        );

        $this->items[] = $menuRouteItemBuilder;

        return $menuRouteItemBuilder;
    }

    public function end(): ?MenuItemBuilderInterface
    {
        return $this->parentItemBuilder;
    }

    public function root(): MenuBuilderInterface
    {
        return $this->menuBuilder;
    }

    public function setGrant(array|string $grant): MenuItemBuilderInterface
    {
        $this->grant = $grant;

        return $this;
    }

    public function setIcon(string $icon): MenuItemBuilderInterface
    {
        $this->icon = $icon;

        return $this;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    protected function build(): MenuItemInterface
    {
        $menuItem = new MenuItem();

        $menuItem->setLabel($this->label);
        $menuItem->setGrant($this->grant);
        $menuItem->setTemplate($this->template);
        $menuItem->setIcon($this->icon);
        $menuItem->setAppendDivider($this->appendDivider);

        foreach ($this->items as $item) {
            if (is_a($item, MenuItemBuilderInterface::class)) {
                /**
                 * @var AbstractBuilder $item
                 */
                $submenuItem = $item->build();

                $menuItem->addMenuItem($submenuItem);
            }
        }

        return $menuItem;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function appendDivider(bool $appendDivider = true): self
    {
        $this->appendDivider = $appendDivider;

        return $this;
    }
}
