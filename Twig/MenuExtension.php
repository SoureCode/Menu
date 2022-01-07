<?php
/*
 * This file is part of the SoureCode package.
 *
 * (c) Jason Schilling <jason@sourecode.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SoureCode\Component\Menu\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('menu_render', [MenuRuntime::class, 'render'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFunction('menu_render_menu', [MenuRuntime::class, 'renderMenu'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFunction('menu_render_menu_item', [MenuRuntime::class, 'renderMenuItem'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }
}
