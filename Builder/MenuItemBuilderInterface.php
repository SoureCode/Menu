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
interface MenuItemBuilderInterface
{
    public function addItem(string $label): self;

    public function addLinkItem(string $label, string $link): self;

    public function addRouteItem(string $label, string $routeName, array $routeParameters = []): self;

    public function end(): ?self;

    public function root(): MenuBuilderInterface;

    public function setGrant(string|array $grant): self;

    public function setIcon(string $icon): self;

    public function setLabel(string $label): self;

    public function setTemplate(string $template): self;
}
