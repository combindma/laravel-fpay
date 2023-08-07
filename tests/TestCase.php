<?php

namespace Combindma\Fpay\Tests;

use Combindma\Fpay\Fpay;
use Combindma\Fpay\FpayServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public Fpay $fpay;

    protected function getPackageProviders($app): array
    {
        return [
            FpayServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.locale', 'fr');
        $app['config']->set('fpay.merchantId', 'valid_string');
        $app['config']->set('fpay.merchantKey', 'valid_string');
        $app['config']->set('fpay.baseUri', 'https://test.fpay.ma');
        $app['config']->set('fpay.callbackUrl', 'https://test.fpay.ma');
        $app['config']->set('fpay.merchantUrl', 'https://test.fpay.ma');
        $this->fpay = new Fpay();
    }
}
