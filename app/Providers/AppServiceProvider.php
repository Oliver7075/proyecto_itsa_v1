<?php

namespace App\Providers;

use App\Models\Instituto;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
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
        config(['functionality.menu' => config('adminlte.menu', [])]);
        $this->filterMenuByPermissions();

        $branding = null;
        $applyBranding = function () use (&$branding): void {
            if ($branding === null) {
                $instituto = Schema::hasTable('instituto')
                    ? Instituto::query()->first()
                    : null;
                $nombre = $instituto?->nombreinstituto ?: 'ITSA';
                $logoGuardado = $instituto?->logo
                    && Storage::disk('public')->exists($instituto->logo);
                $logo = $logoGuardado
                    ? url('storage/'.$instituto->logo)
                    : asset('images/itsa-mark.svg');

                $branding = [
                    'app.name' => $nombre,
                    'adminlte.title' => 'ITSA',
                    'adminlte.title_postfix' => ' | '.$nombre,
                    'adminlte.logo' => '<span class="itsa-brand-word">ITSA</span>',
                    'adminlte.logo_img' => $logo,
                    'adminlte.logo_img_alt' => $nombre,
                    'adminlte.auth_logo.enabled' => true,
                    'adminlte.auth_logo.img.path' => $logo,
                    'adminlte.auth_logo.img.alt' => $nombre,
                    'adminlte.preloader.img.path' => $logo,
                    'adminlte.preloader.img.alt' => $nombre,
                ];
            }

            config($branding);
        };

        View::composer([
            'adminlte::page',
            'adminlte::auth.auth-page',
            'adminlte::auth.passwords.confirm',
            'adminlte::master',
            'welcome',
        ], $applyBranding);
    }

    protected function filterMenuByPermissions(): void
    {
        if (! auth()->check()) {
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
            if (! empty($item['type'])) {
                $filtered[] = $item;

                continue;
            }

            if (! empty($item['url'])) {
                $url = trim((string) $item['url'], '/');
                if (! $user->canAccess($url)) {
                    continue;
                }
                $filtered[] = $item;

                continue;
            }

            if (! empty($item['submenu']) && is_array($item['submenu'])) {
                $submenu = $this->filterMenuItems($item['submenu'], $user);

                if (! empty($submenu)) {
                    $item['submenu'] = $submenu;
                    $filtered[] = $item;
                }
            }
        }

        return $filtered;
    }
}
