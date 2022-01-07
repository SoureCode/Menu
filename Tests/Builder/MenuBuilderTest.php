<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Tests\Builder;

use PHPUnit\Framework\TestCase;
use SoureCode\Component\Menu\Builder\Director;
use SoureCode\Component\Menu\Builder\MenuBuilder;
use SoureCode\Component\Menu\Builder\MenuItemBuilder;
use SoureCode\Component\Menu\Model\MenuInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuBuilderTest extends TestCase
{
    public function testAddItem(): void
    {
        $builder = new MenuBuilder('test');

        $itemBuilder = $builder->addItem('foo');

        $director = new Director($builder);

        /**
         * @var MenuInterface $built
         */
        $built = $director->build();

        $this->assertInstanceOf(MenuItemBuilder::class, $itemBuilder);
        $this->assertCount(1, $built->getMenuItems());
        $this->assertSame('foo', $built->getMenuItems()->get(0)->getLabel());
    }

    public function testAddLinkItem(): void
    {
        $builder = new MenuBuilder('test');

        $itemBuilder = $builder->addLinkItem('foo', 'https://example.com');

        $director = new Director($builder);

        /**
         * @var MenuInterface $built
         */
        $built = $director->build();

        $this->assertInstanceOf(MenuItemBuilder::class, $itemBuilder);
        $this->assertCount(1, $built->getMenuItems());
        $this->assertSame('foo', $built->getMenuItems()->get(0)->getLabel());
        $this->assertSame('https://example.com', $built->getMenuItems()->get(0)->getLink());
    }

    public function testAddRouteItem(): void
    {
        $builder = new MenuBuilder('test');

        $itemBuilder = $builder->addRouteItem('foo', 'test_route');

        $director = new Director($builder);

        /**
         * @var MenuInterface $built
         */
        $built = $director->build();

        $this->assertInstanceOf(MenuItemBuilder::class, $itemBuilder);
        $this->assertCount(1, $built->getMenuItems());
        $this->assertSame('foo', $built->getMenuItems()->get(0)->getLabel());
        $this->assertSame('test_route', $built->getMenuItems()->get(0)->getRouteName());
    }

    public function testName(): void
    {
        $builder = new MenuBuilder('test');
        $director = new Director($builder);

        $built = $director->build();

        $this->assertEquals('test', $built->getName());
    }

    public function testSetLabel(): void
    {
        $builder = new MenuBuilder('test');
        $builder->setLabel('foo');
        $director = new Director($builder);

        $built = $director->build();

        $this->assertEquals('foo', $built->getLabel());

        $builder->setLabel('bar');
        $built = $director->build();

        $this->assertEquals('bar', $built->getLabel());
    }
}
