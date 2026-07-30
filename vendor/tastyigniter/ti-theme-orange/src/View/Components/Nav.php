<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class Nav extends Component
{
    public array $menuItems = [];

    public string $activePage;

    public function __construct(public string $code)
    {
        $this->activePage = controller()->getPage()->getId();
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::includes.navs.'.$this->code, [
            'menuItems' => $this->menuItems(),
        ]);
    }

    protected function menuItems(): array
    {
        $themeCode = controller()->getTheme()->getName();

        if ($menu = Menu::whereCode($this->code)->where('theme_code', $themeCode)->first()) {
            /** @var Menu $menu */
            $this->menuItems = resolve(MenuManager::class)->generateReferences($menu, controller()->getLayout());
        }

        return $this->menuItems;
    }
}
