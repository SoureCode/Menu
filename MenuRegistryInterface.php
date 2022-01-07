<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu;

use SoureCode\Component\Menu\Model\MenuInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
interface MenuRegistryInterface
{
    public function add(AbstractMenu $menu): void;

    public function build(string $name): MenuInterface;

    public function get(string $name): AbstractMenu;

    public function has(string $name): bool;
}
