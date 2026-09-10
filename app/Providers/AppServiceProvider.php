<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->filterMenuByPermissions();
    }

    protected function filterMenuByPermissions(): void
    {
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();
        $menu = config('adminlte.menu', []);

        config(['adminlte.menu' => $this->filterMenuItems($menu, $user)]);
    }

    protected function filterMenuItems(array $items, $user): array
    {
        $filtered = [];

        foreach ($items as $item) {
            if (!empty($item['type'])) {
                $filtered[] = $item;
                continue;
            }

            if (!empty($item['url'])) {
                $url = trim((string) $item['url'], '/');
                if (!$user->canAccess($url)) {
                    continue;
                }
                $filtered[] = $item;
                continue;
            }

            if (!empty($item['submenu']) && is_array($item['submenu'])) {
                $submenu = $this->filterMenuItems($item['submenu'], $user);

                if (!empty($submenu)) {
                    $item['submenu'] = $submenu;
                    $filtered[] = $item;
                }
            }
        }

        return $filtered;
    }
}
