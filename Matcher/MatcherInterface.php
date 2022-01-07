<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Matcher;

use SoureCode\Component\Menu\Model\MenuItemInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
interface MatcherInterface
{
    public function isCurrent(MenuItemInterface $menuItem): bool;

    public function isAncestor(MenuItemInterface $menuItem, ?int $depth = null): bool;

    public function clear(): void;
}
