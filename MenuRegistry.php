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

use SoureCode\Component\Menu\Builder\Director;
use SoureCode\Component\Menu\Builder\MenuBuilder;
use SoureCode\Component\Menu\Model\MenuInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuRegistry implements MenuRegistryInterface
{
    /**
     * @var array<string, MenuInterface>
     */
    protected array $cache = [];

    /**
     * @var array<string, AbstractMenu>
     */
    protected array $menuServices = [];

    public function add(AbstractMenu $menu): void
    {
        $this->menuServices[$menu->getName()] = $menu;
    }

    public function build(string $name): MenuInterface
    {
        if (!isset($this->cache[$name])) {
            $menuService = $this->get($name);
            $menuBuilder = new MenuBuilder($menuService->getName());

            $menuService->buildMenu($menuBuilder);
            $director = new Director($menuBuilder);

            $this->cache[$name] = $director->build();
        }

        return $this->cache[$name];
    }

    public function get(string $name): AbstractMenu
    {
        if (!isset($this->menuServices[$name])) {
            throw new \InvalidArgumentException(sprintf('Menu "%s" does not exist.', $name));
        }

        return $this->menuServices[$name];
    }

    public function has(string $name): bool
    {
        return isset($this->menuServices[$name]);
    }
}
