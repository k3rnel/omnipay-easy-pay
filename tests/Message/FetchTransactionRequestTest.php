<?php

declare(strict_types=1);

namespace Tests\Message;

use Omnipay\EasyPay\Message\FetchTransactionRequest;
use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
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
    }
}
