<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected const API_ENDPOINT = 'https://merchantapi.easypay.am:3003/EPMerchantService.svc';

    /**
     * @return string
     */
    abstract protected function getEndpoint(): string;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Omnipay\EasyPay\Message\AbstractResponse
     */
    abstract protected function createResponse(PsrResponseInterface $response): AbstractResponse;

    /**
     * @return string
     */
    abstract protected function buildChecksum(): string;

    /**
     * @return array
     */
    abstract public function getData(): array;

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
     * @return \Omnipay\EasyPay\Message\AbstractRequest
     */
    public function setMerchantId(string $value): AbstractRequest
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
     * @return \Omnipay\EasyPay\Message\AbstractRequest
     */
    public function setMerchantToken(string $value): AbstractRequest
    {
        return $this->setParameter('merchantToken', $value);
    }

    /**
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $data['MerchantId'] = $this->getMerchantId();
        $data['Checksum'] = $this->buildChecksum();

        $body = json_encode($data, JSON_THROW_ON_ERROR);

        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Content-Type' => 'application/json',
            ],
            $body,
        );

        return $this->createResponse($response);
    }
}
