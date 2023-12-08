<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @param \Omnipay\EasyPay\Message\PurchaseRequest $request
     * @param array                                    $data
     */
    public function __construct(PurchaseRequest $request, array $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @return string|null
     */
    public function getTransactionReference(): ?string
    {
        return $this->data['id'] ?? null;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return !empty($this->data['response']) && !empty($this->data['id']);
    }

    /**
     * @return bool
     */
    public function isRedirect(): bool
    {
        return $this->isSuccessful();
    }

    /**
     * @return string
     */
    public function getRedirectMethod(): string
    {
        return 'GET';
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        if (!$this->isSuccessful()) {
            return null;
        }

        return $this->data['response'];
    }
}
