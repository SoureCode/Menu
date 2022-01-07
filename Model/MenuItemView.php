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

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use IteratorAggregate;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 *
 * @implements ArrayAccess<array-key, MenuItemView>
 * @implements IteratorAggregate<array-key, MenuItemView>
 */
class MenuItemView implements \ArrayAccess, \IteratorAggregate, \Countable
{
    public array $vars = [
    ];

    public ?MenuItemView $parent;

    /**
     * @var array<array-key, MenuItemView>
     */
    public array $items = [];

    public function __construct(self $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @param array-key $name
     */
    public function offsetGet(mixed $name): self
    {
        return $this->items[$name];
    }

    /**
     * @param array-key $name
     */
    public function offsetExists(mixed $name): bool
    {
        return isset($this->items[$name]);
    }

    /**
     * @throws BadMethodCallException always as setting a child by name is not allowed
     */
    public function offsetSet(mixed $name, mixed $value): void
    {
        throw new BadMethodCallException('Not supported.');
    }

    /**
     * @param array-key $name
     */
    public function offsetUnset(mixed $name): void
    {
        unset($this->items[$name]);
    }

    /**
     * @return ArrayIterator<array-key, MenuItemView>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }
}
