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

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
interface MenuBuilderInterface
{
    public function setLabel(string $label): self;

    public function addItem(string $label): MenuItemBuilderInterface;

    public function addLinkItem(string $label, string $link): LinkMenuItemBuilderInterface;

    public function addRouteItem(string $label, string $routeName, array $routeParameters = []): RouteMenuItemBuilderInterface;
}
