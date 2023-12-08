<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Message;

use Omnipay\EasyPay\Enums\TransactionStatus;

class FetchTransactionResponse extends AbstractResponse
{
    /**
     * @param \Omnipay\EasyPay\Message\FetchTransactionRequest $request
     * @param array                                            $data
     */
    public function __construct(FetchTransactionRequest $request, array $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->data['success'] === true;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getStatus() === TransactionStatus::PENDING;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->getStatus() === TransactionStatus::NEW;
    }

    /**
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->getStatus() === TransactionStatus::REJECTED;
    }

    /**
     * @return \Omnipay\EasyPay\Enums\TransactionStatus|null
     */
    public function getStatus(): ?TransactionStatus
    {
        return TransactionStatus::tryFrom($this->data['status']);
    }
}
