<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Message;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method string getAmount()
 * @method string getTransactionId()
 * @method PurchaseRequest setAmount(string|int $value)
 * @method PurchaseRequest setTransactionId(string $value)
 *
 * @uses \Omnipay\Common\Message\AbstractRequest::getAmount()
 * @uses \Omnipay\Common\Message\AbstractRequest::setAmount()
 * @uses \Omnipay\Common\Message\AbstractRequest::getTransactionId()
 * @uses \Omnipay\Common\Message\AbstractRequest::setTransactionId()
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return self::API_ENDPOINT.'/createorder';
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('transactionId', 'amount');

        return [
            'MerchantOrderId' => $this->getTransactionId(),
            'Amount'          => $this->getAmount(),
        ];
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Omnipay\EasyPay\Message\PurchaseResponse
     * @throws \JsonException
     */
    protected function createResponse(ResponseInterface $response): PurchaseResponse
    {
        $data = [];

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $responseData = json_decode(
                $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );

            if (is_string($responseData)) {
                if ($responseData === 'Unauthorized') {
                    $data['success'] = false;
                    $data['response'] = 'Unauthorized';
                } else {
                    $queryString = parse_url($responseData, PHP_URL_QUERY);

                    parse_str($queryString, $queryParams);

                    $data['success'] = true;
                    $data['response'] = $responseData;
                    $data['id'] = $queryParams['id'] ?? null;
                }
            }
        }

        return new PurchaseResponse($this, $data);
    }

    /**
     * @return string
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function buildChecksum(): string
    {
        return md5(
            "{$this->getMerchantId()}{$this->getTransactionId()}{$this->getAmount()}{$this->getMerchantToken()}"
        );
    }
}
