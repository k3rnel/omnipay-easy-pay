<?php

declare(strict_types=1);

namespace Omnipay\EasyPay\Enums;

enum TransactionStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';

    case REJECTED = 'rejected';

    case PAID = 'paid';
}
