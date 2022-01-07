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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class Menu implements MenuInterface
{
    /**
     * @var Collection<int, MenuItemInterface>
     */
    protected Collection $items;

    protected ?string $name = null;

    protected ?string $label = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function addMenuItem(MenuItemInterface $menuItem): self
    {
        if (!$this->items->contains($menuItem)) {
            $this->items->add($menuItem);

            $menuItem->setMenu($this);
        }

        return $this;
    }

    public function getMenuItems(): Collection
    {
        return $this->items;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function removeMenuItem(MenuItemInterface $menuItem): self
    {
        if ($this->items->contains($menuItem)) {
            $this->items->removeElement($menuItem);

            $menuItem->setMenu(null);
        }

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function createView(): MenuView
    {
        $view = new MenuView();

        $view->vars['name'] = $this->getName();
        $view->vars['label'] = $this->getLabel();

        $view->vars['menu'] = $this;

        foreach ($this->items as $item) {
            $view->items[] = $item->createView();
        }

        return $view;
    }
}
