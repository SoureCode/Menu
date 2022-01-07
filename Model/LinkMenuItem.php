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
class LinkMenuItem extends MenuItem implements LinkMenuItemInterface
{
    protected ?string $link = null;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function createView(MenuItemView $parent = null): MenuItemView
    {
        $view = parent::createView($parent);

        $view->vars['link'] = $this->getLink();

        return $view;
    }
}
