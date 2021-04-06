<?php

declare(strict_types=1);

namespace Codeat3\BladeEvilIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

final class BladeEvilIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('evil-icons', [
                'path' => __DIR__.'/../resources/svg',
                'prefix' => 'ei',
            ]);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-ei'),
            ], 'blade-ei');
        }
    }
}
