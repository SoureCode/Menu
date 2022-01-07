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
use SoureCode\Component\Menu\Model\RouteMenuItemInterface;
use SplObjectStorage;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class Matcher implements MatcherInterface
{
    /**
     * @var SplObjectStorage<MenuItemInterface, bool>
     */
    private SplObjectStorage $cache;

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->cache = new SplObjectStorage();
    }

    public function clear(): void
    {
        $this->cache = new SplObjectStorage();
    }

    public function isAncestor(MenuItemInterface $menuItem, ?int $depth = null): bool
    {
        if (0 === $depth) {
            return false;
        }

        $childDepth = null === $depth ? null : $depth - 1;

        foreach ($menuItem->getMenuItems() as $child) {
            if ($this->isCurrent($child) || $this->isAncestor($child, $childDepth)) {
                return true;
            }
        }

        return false;
    }

    public function isCurrent(MenuItemInterface $menuItem): bool
    {
        if (!$this->cache->contains($menuItem)) {
            $this->cache[$menuItem] = $this->isCurrentMenuItem($menuItem);
        }

        return $this->cache[$menuItem];
    }

    private function isCurrentMenuItem(MenuItemInterface $menuItem): bool
    {
        if (!($menuItem instanceof RouteMenuItemInterface)) {
            return false;
        }

        $request = $this->requestStack->getMainRequest();

        if (null === $request) {
            return false;
        }

        $requestRoute = $request->attributes->get('_route');
        $requestRouteParameters = $request->attributes->get('_route_params', []);

        if (null === $requestRoute) {
            return false;
        }

        if ($menuItem->getRouteName() !== $requestRoute) {
            return false;
        }

        $routeParameters = $menuItem->getRouteParameters() ?? [];

        foreach ($routeParameters as $key => $value) {
            if (!isset($requestRouteParameters[$key]) || (string) $requestRouteParameters[$key] !== (string) $value) {
                return false;
            }
        }

        return true;
    }
}
