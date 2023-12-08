<?php

declare(strict_types=1);

namespace Tests\Message;

use Omnipay\EasyPay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'amount'        => '10',
            'transactionId' => 'some-transaction-id',
        ]);
    }

    /**
     * @return void
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testGetData(): void
    {
        $data = $this->request->getData();

        $this->assertIsArray($data);
        $this->assertEquals('some-transaction-id', $data['MerchantOrderId']);
        $this->assertEquals('10.00', $data['Amount']);
    }
}
