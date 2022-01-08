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
    private string $defaultTemplateName;

    private Matcher $matcher;

    private MenuRegistryInterface $menuRegistry;

    private Security $security;

    public function __construct(
        MenuRegistryInterface $menuRegistry,
        Matcher $matcher,
        Security $security,
        ?string $defaultTemplateName = null
    ) {
        $this->menuRegistry = $menuRegistry;
        $this->matcher = $matcher;
        $this->security = $security;
        $this->defaultTemplateName = $defaultTemplateName ?? 'soure_code_menu.html.twig';
    }

    public function render(Environment $environment, string $menuName, ?string $templateName = null): string
    {
        $menu = $this->menuRegistry->build($menuName);

        $grant = $menu->getGrant();

        if (null !== $grant && !$this->security->isGranted($grant)) {
            return '';
        }

        $menuView = $menu->createView();
        $menuView->vars['template'] = $templateName ?? $menuView->vars['template'] ?? $this->defaultTemplateName;

        $rendered = $this->renderMenu($environment, $menuView);

        $this->matcher->clear();

        return $rendered;
    }

    public function renderMenu(Environment $environment, MenuView $menuView, ?string $templateName = null): string
    {
        $templateName = $templateName ?? $menuView->vars['template'] ?? $this->defaultTemplateName;

        $menuView->vars['template'] = $templateName;

        $this->walkView($menuView, function (MenuView|MenuItemView $view) use ($menuView) {
            if (!$view instanceof MenuItemView) {
                return;
            }

            /**
             * @var MenuItemInterface $item
             */
            $item = $view->vars['item'];

            if (null === $view->vars['template']) {
                $view->vars['template'] = $menuView->vars['template'];
            }

            $view->vars['is_current'] = $this->matcher->isCurrent($item);
            $view->vars['is_ancestor'] = $this->matcher->isAncestor($item);
        });

        $template = $environment->resolveTemplate($templateName);

        ob_start();

        $template->displayBlock(
            'menu',
            array_merge(
                $menuView->vars,
                [
                    'item' => $menuView,
                ]
            )
        );

        return ob_get_clean();
    }

    private function walkView(IteratorAggregate $view, callable $callback): void
    {
        foreach ($view as $value) {
            $callback($value);

            $this->walkView($value, $callback);
        }
    }

    public function renderMenuBlock(
        Environment $environment,
        array $context,
        string $blockName,
        ?string $templateName = null
    ): string {
        $templateName = $templateName ?? $this->defaultTemplateName;
        $template = $environment->resolveTemplate($templateName);

        ob_start();

        $template->displayBlock($blockName, $context);

        return ob_get_clean();
    }

    public function renderMenuItem(Environment $environment, MenuItemView $menuItemView, ?string $templateName = null): string
    {
        /**
         * @var MenuItemInterface $item
         */
        $item = $menuItemView->vars['item'];
        $grant = $item->getGrant();

        if (null !== $grant && !$this->security->isGranted($grant)) {
            return '';
        }

        $templateName = $templateName ?? $menuItemView->vars['template'] ?? $this->defaultTemplateName;
        $menuItemView->vars['template'] = $templateName;

        $template = $environment->resolveTemplate($templateName);

        ob_start();

        $template->displayBlock(
            'menu_item',
            array_merge(
                $menuItemView->vars,
                [
                    'item' => $menuItemView,
                ]
            )
        );

        return ob_get_clean();
    }
}
