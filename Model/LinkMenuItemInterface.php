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
interface LinkMenuItemInterface extends MenuItemInterface
{
    public function getLink(): ?string;

    public function setLink(?string $link): self;
}
