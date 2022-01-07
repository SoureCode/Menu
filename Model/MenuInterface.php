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
interface MenuInterface
{
    public function getName(): ?string;

    public function setName(?string $name): self;

    public function getLabel(): ?string;

    public function setLabel(?string $label): self;

    public function getMenuItems(): Collection;

    public function addMenuItem(MenuItemInterface $menuItem): self;

    public function removeMenuItem(MenuItemInterface $menuItem): self;

    public function createView(): MenuView;
}
