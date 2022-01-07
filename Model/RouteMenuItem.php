<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Model;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class RouteMenuItem extends MenuItem implements RouteMenuItemInterface
{
    private ?string $routeName = null;

    private ?array $routeParameters = null;

    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    public function getRouteParameters(): ?array
    {
        return $this->routeParameters;
    }

    public function setRouteName(?string $routeName): self
    {
        $this->routeName = $routeName;

        return $this;
    }

    public function setRouteParameters(?array $routeParameters): self
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    public function createView(MenuItemView $parent = null): MenuItemView
    {
        $view = parent::createView($parent);

        $view->vars['routeName'] = $this->getRouteName();
        $view->vars['routeParameters'] = $this->getRouteParameters();

        return $view;
    }
}
