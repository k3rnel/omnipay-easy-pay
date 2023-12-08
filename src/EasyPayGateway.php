<?php

declare(strict_types=1);

namespace Omnipay\EasyPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\EasyPay\Message\FetchTransactionRequest;
use Omnipay\EasyPay\Message\PurchaseRequest;

/**
 * EasyPay gateway.
 *
 * @package Omnipay\EasyPay
 */
class EasyPayGateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'EasyPay';
    }

    /**
     * Gateway default parameters.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'merchantId'    => null,
            'merchantToken' => null,
            'testMode'      => false, // Easy Pay does not yet support test mode.
        ];
    }

    /**
     * Merchant ID getter.
     *
     * @return string|null
     */
    public function getMerchantId(): ?string
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Merchant ID setter.
     *
     * @param string $value
     *
     * @return \Omnipay\EasyPay\EasyPayGateway
     */
    public function setMerchantId(string $value): EasyPayGateway
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Merchant token getter.
     *
     * @return string|null
     */
    public function getMerchantToken(): ?string
    {
        return $this->getParameter('merchantToken');
    }

    /**
     * Merchant token setter
     *
     * @param string $value
     *
     * @return \Omnipay\EasyPay\EasyPayGateway
     */
    public function setMerchantToken(string $value): EasyPayGateway
    {
        return $this->setParameter('merchantToken', $value);
    }

    /**
     * Create purchase request.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * Create fetch transaction request.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function fetchTransaction(array $options = []): AbstractRequest
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }
}
