<?php

namespace Combindma\Fpay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Combindma\Fpay\Fpay
 */
class Fpay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Combindma\Fpay\Fpay::class;
    }
}
