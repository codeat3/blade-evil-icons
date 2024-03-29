<?php

declare(strict_types=1);

namespace Codeat3\BladeEvilIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeEvilIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-evil-icons', []);

            $factory->add('evil-icons', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-evil-icons.php', 'blade-evil-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-evil-icons'),
            ], 'blade-ei'); // TODO: change this alias to `blade-evil-icons` in the next major release

            $this->publishes([
                __DIR__ . '/../config/blade-evil-icons.php' => $this->app->configPath('blade-evil-icons.php'),
            ], 'blade-evil-icons-config');
        }
    }
}
