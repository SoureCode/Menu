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

use Doctrine\Common\Collections\Collection;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
interface MenuItemInterface
{
    public function addMenuItem(self $child): self;

    public function getMenuItems(): Collection;

    public function hasMenuItems(): bool;

    public function getLabel(): ?string;

    public function getMenu(): ?MenuInterface;

    public function getIcon(): ?string;

    public function setIcon(?string $icon): self;

    public function getParent(): ?self;

    public function removeMenuItem(self $child): self;

    public function setLabel(?string $label): self;

    public function setMenu(?MenuInterface $menu): self;

    public function setParent(?self $parent): self;

    public function getGrant(): string|array|null;

    public function setGrant(string|array|null $grant): self;

    public function setTemplate(?string $template): self;

    public function getTemplate(): ?string;

    public function createView(MenuItemView $parent = null): MenuItemView;
}
