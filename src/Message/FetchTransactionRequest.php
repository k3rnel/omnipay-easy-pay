<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Message;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method string getTransactionId()
 * @method FetchTransactionRequest setTransactionId(string $value)
 * @method string getTransactionReference()
 * @method FetchTransactionRequest setTransactionReference($value)
 *
 * @uses \Omnipay\Common\Message\AbstractRequest::getTransactionId()
 * @uses \Omnipay\Common\Message\AbstractRequest::setTransactionId()
 * @uses \Omnipay\Common\Message\AbstractRequest::getTransactionReference()
 * @uses \Omnipay\Common\Message\AbstractRequest::setTransactionReference()
 */
class FetchTransactionRequest extends AbstractRequest
{
    protected function getEndpoint(): string
    {
        return self::API_ENDPOINT.'/checkorder';
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Omnipay\EasyPay\Message\AbstractResponse
     * @throws \JsonException
     */
    protected function createResponse(PsrResponseInterface $response): AbstractResponse
    {
        $data = [
            'success' => false,
        ];

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $responseData = trim($response->getBody()->getContents(), '"');

            if ($responseData === 'Unauthorized') {
                $data['response'] = 'Unauthorized';
            } else {
                $data['success'] = true;
                $data['status'] = $responseData;
            }
        }

        return new FetchTransactionResponse($this, $data);
    }

    /**
     * @return string
     */
    protected function buildChecksum(): string
    {
        return md5(
            "{$this->getMerchantId()}{$this->getTransactionId()}{$this->getTransactionReference()}{$this->getMerchantToken()}"
        );
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('transactionId');

        $data = [
            'MerchantOrderId' => $this->getTransactionId(),
        ];

        if (!empty($this->getTransactionReference())) {
            $data['QR GUID'] = $this->getTransactionReference();
        }

        return $data;
    }
}
