<?php

declare(strict_types=1);

namespace Tests;

use Omnipay\EasyPay\EasyPayGateway;
use Omnipay\Omnipay;
use Omnipay\Tests\GatewayTestCase;

/**
 * @property EasyPayGateway $gateway
 */
class EasyPayGatewayTest extends GatewayTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->gateway = Omnipay::create(EasyPayGateway::class, $this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('some-merchant-id');
        $this->gateway->setMerchantToken('some-merchant-gu-id-token');
        $this->options = [
            'amount' => '10',
        ];
    }
}
