<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Builder;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class Director extends AbstractBuilder
{
    protected AbstractBuilder $builder;

    public function __construct(AbstractBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function build(): mixed
    {
        return $this->builder->build();
    }
}
