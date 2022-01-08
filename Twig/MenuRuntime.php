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

use IteratorAggregate;
use SoureCode\Component\Menu\Matcher\Matcher;
use SoureCode\Component\Menu\MenuRegistryInterface;
use SoureCode\Component\Menu\Model\MenuItemInterface;
use SoureCode\Component\Menu\Model\MenuItemView;
use SoureCode\Component\Menu\Model\MenuView;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @author Jason Schilling <jason@sourecode.dev>
 */
class MenuRuntime implements RuntimeExtensionInterface
{
    private array $defaultOptions;

    private Matcher $matcher;

    private MenuRegistryInterface $menuRegistry;

    private Security $security;

    public function __construct(MenuRegistryInterface $menuRegistry, Matcher $matcher, Security $security, array $defaultOptions = [])
    {
        $this->menuRegistry = $menuRegistry;
        $this->matcher = $matcher;
        $this->security = $security;
        $this->defaultOptions = array_merge([
            'template' => 'soure_code_menu.html.twig',
            'clear_matcher' => true,
            'current_as_link' => true,
        ], $defaultOptions);
    }

    public function renderMenuBlock(Environment $environment, array $context, string $blockName, ?string $templateName = null): string
    {
        $templateName = $templateName ?? $this->defaultOptions['template'];
        $template = $environment->resolveTemplate($templateName);

        ob_start();

        $template->displayBlock($blockName, $context);

        return ob_get_clean();
    }

    public function render(Environment $environment, string $menuName, array $options = []): string
    {
        $options = array_merge($this->defaultOptions, $options);
        $menu = $this->menuRegistry->build($menuName);
        $menuView = $menu->createView();

        $this->walkView($menuView, function (MenuView|MenuItemView $view) {
            if (!$view instanceof MenuItemView) {
                return;
            }

            $item = $view->vars['item'];

            $view->vars['is_current'] = $this->matcher->isCurrent($item);
            $view->vars['is_ancestor'] = $this->matcher->isAncestor($item);
        });

        $rendered = $this->renderMenu($environment, $menuView, $options);

        if ($options['clear_matcher']) {
            $this->matcher->clear();
        }

        return $rendered;
    }

    private function walkView(IteratorAggregate $view, callable $callback): void
    {
        foreach ($view as $value) {
            $callback($value);

            $this->walkView($value, $callback);
        }
    }

    public function renderMenu(Environment $environment, MenuView $menuView, array $options = []): string
    {
        $options = array_merge($this->defaultOptions, $options);
        $template = $environment->resolveTemplate($options['template']);

        ob_start();

        $template->displayBlock(
            'menu',
            array_merge(
                $menuView->vars,
                [
                    'menu' => $menuView,
                    'options' => $options,
                ]
            )
        );

        return ob_get_clean();
    }

    public function renderMenuItem(Environment $environment, MenuItemView $menuItemView, array $options = []): string
    {
        /**
         * @var MenuItemInterface $item
         */
        $item = $menuItemView->vars['item'];
        $grant = $item->getGrant();

        if (null !== $grant && !$this->security->isGranted($grant)) {
            return '';
        }

        $options = array_merge($this->defaultOptions, $options);
        $template = $environment->resolveTemplate($options['template']);

        ob_start();

        $template->displayBlock(
            'menu_item',
            array_merge(
                $menuItemView->vars,
                [
                    'item' => $menuItemView,
                    'options' => $options,
                ]
            )
        );

        return ob_get_clean();
    }
}
