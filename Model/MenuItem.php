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
class MenuItem implements MenuItemInterface
{
    protected string|array|null $grant = null;

    protected ?string $icon = null;

    /**
     * @var Collection<int, MenuItemInterface>
     */
    protected Collection $items;

    protected ?string $label = null;

    protected ?MenuInterface $menu = null;

    protected ?MenuItemInterface $parent = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function addMenuItem(MenuItemInterface $child): self
    {
        if (!$this->items->contains($child)) {
            $this->items->add($child);

            $child->setParent($this);
        }

        return $this;
    }

    public function createView(MenuItemView $parent = null): MenuItemView
    {
        $view = new MenuItemView($parent);

        $view->vars['label'] = $this->getLabel();
        $view->vars['icon'] = $this->getIcon();
        $view->vars['grant'] = $this->getGrant();

        $view->vars['item'] = $this;
        $view->vars['menu'] = $this->getMenu();

        foreach ($this->items as $item) {
            $view->items[] = $item->createView($view);
        }

        return $view;
    }

    public function getGrant(): string|array|null
    {
        return $this->grant;
    }

    public function setGrant(array|string|null $grant): MenuItemInterface
    {
        $this->grant = $grant;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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

    public function getMenu(): ?MenuInterface
    {
        return $this->menu;
    }

    public function setMenu(?MenuInterface $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getMenuItems(): Collection
    {
        return $this->items;
    }

    public function getParent(): ?MenuItemInterface
    {
        return $this->parent;
    }

    public function setParent(?MenuItemInterface $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function hasMenuItems(): bool
    {
        return !$this->items->isEmpty();
    }

    public function removeMenuItem(MenuItemInterface $child): self
    {
        if ($this->items->contains($child)) {
            $this->items->removeElement($child);

            $child->setParent(null);
        }

        return $this;
    }
}
