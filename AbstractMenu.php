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

use SoureCode\Component\Menu\Builder\MenuBuilderInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
abstract class AbstractMenu
{
    abstract public function buildMenu(MenuBuilderInterface $menuBuilder, array $context = []): void;

    public function getGrant(): string|array|null
    {
        return null;
    }

    abstract public function getName(): string;

    public function getTemplate(): ?string
    {
        return null;
    }
}
