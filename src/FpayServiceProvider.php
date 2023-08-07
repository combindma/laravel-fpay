<?php

namespace Combindma\Fpay;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FpayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('fpay')
            ->hasConfigFile('fpay')
            ->hasViews();
    }

    public function packageRegistered()
    {
        $this->app->bind('fpay', function ($app) {
            return new Fpay();
        });
    }
}
