<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Message;

use Omnipay\Common\Message\AbstractResponse as BaseAbstractResponse;

abstract class AbstractResponse extends BaseAbstractResponse
{
    /**
     * @param \Omnipay\EasyPay\Message\AbstractRequest $request
     * @param array                                    $data
     */
    public function __construct(AbstractRequest $request, mixed $data)
    {
        parent::__construct($request, $data);
    }
}
