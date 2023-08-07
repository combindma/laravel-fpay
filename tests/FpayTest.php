<?php

it('can test if config file are set', function () {
    expect($this->fpay->getBaseUri())->toBe('https://test.fpay.ma')
        ->and($this->fpay->getShopUrl())->toBe('https://test.fpay.ma');
});
