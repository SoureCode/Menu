<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Tests\Matcher;

use PHPUnit\Framework\TestCase;
use SoureCode\Component\Menu\Matcher\Matcher;
use SoureCode\Component\Menu\Matcher\MatcherInterface;
use SoureCode\Component\Menu\Model\LinkMenuItem;
use SoureCode\Component\Menu\Model\RouteMenuItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MatcherTest extends TestCase
{
    protected ?MatcherInterface $matcher = null;

    protected ?RequestStack $requestStack = null;

    public function testIsCurrent(): void
    {
        $item = new RouteMenuItem();
        $item->setRouteName('test_route');

        $item1 = new RouteMenuItem();
        $item1->setRouteName('test_route1');

        $this->assertTrue($this->matcher->isCurrent($item));
        $this->assertFalse($this->matcher->isCurrent($item1));
    }

    public function testIsAncestor(): void
    {
        $item = new RouteMenuItem();
        $item->setRouteName('test_route2');

        $item1 = new RouteMenuItem();
        $item1->setRouteName('test_route1');

        $item2 = new RouteMenuItem();
        $item2->setRouteName('test_route');

        $item3 = new RouteMenuItem();
        $item3->setRouteName('test_route3');

        $item->addMenuItem($item1);
        $item1->addMenuItem($item2);
        $item2->addMenuItem($item3);

        $this->assertTrue($this->matcher->isAncestor($item));
        $this->assertTrue($this->matcher->isAncestor($item1));
        $this->assertFalse($this->matcher->isAncestor($item2));
        $this->assertFalse($this->matcher->isAncestor($item3));
    }

    public function testIsCurrentWithLinkMenuItem(): void
    {
        $item = new LinkMenuItem();
        $item->setLink('/test');

        $this->assertFalse($this->matcher->isCurrent($item));
    }

    public function testWithoutRequest(): void
    {
        $this->requestStack->pop();

        $item = new RouteMenuItem();
        $item->setRouteName('test');

        $this->assertFalse($this->matcher->isCurrent($item));
    }

    public function testWithRequestWithoutRouteAttribute(): void
    {
        $this->requestStack->getCurrentRequest()->attributes->remove('_route');

        $item = new RouteMenuItem();
        $item->setRouteName('test_route');

        $this->assertFalse($this->matcher->isCurrent($item));
    }

    public function testIsCurrentWithMatchingRouteParameters(): void
    {
        $item = new RouteMenuItem();
        $item->setRouteName('test_route');
        $item->setRouteParameters(['id' => 1]);

        $this->requestStack->getCurrentRequest()->attributes->set('_route_params', ['id' => 1]);

        $this->assertTrue($this->matcher->isCurrent($item));

        $this->matcher->clear();

        $this->requestStack->getCurrentRequest()->attributes->set('_route_params', ['id' => 2]);

        $this->assertFalse($this->matcher->isCurrent($item));
    }

    protected function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('_route', 'test_route');

        $this->requestStack->push($request);

        $this->matcher = new Matcher($this->requestStack);
    }

    protected function tearDown(): void
    {
        $this->matcher = null;
        $this->requestStack = null;
    }
}
