<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class ArcoSpedizioniServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('arco-spedizioni-sdk')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(ArcoSpedizioni::class, function (): ArcoSpedizioni {
            /** @var ?string $username */
            $username = config('arco-spedizioni-sdk.username');

            /** @var ?string $password */
            $password = config('arco-spedizioni-sdk.password');

            return new ArcoSpedizioni($username, $password);
        });
    }
}
