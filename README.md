# Omnipay: EasyPay

**EasyPay driver for the Omnipay Laravel payment processing library**

[![Latest Stable Version](https://poser.pugx.org/k3rnel/omnipay-easy-pay/version.png)](https://packagist.org/packages/k3rnel/omnipay-easy-pay)
[![Total Downloads](https://poser.pugx.org/k3rnel/omnipay-easy-pay/d/total.png)](https://packagist.org/packages/k3rnel/omnipay-easy-pay)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework-agnostic, multi-gateway payment
processing library for PHP 5.5+. This package implements EasyPay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "k3rnel/omnipay-easy-pay": "^1.0"
    }
}
```

And run composer to update your dependencies:

    composer update

Or you can simply run

    composer require k3rnel/omnipay-easy-pay

## Basic Usage

1. Initialize EasyPay gateway:

```php

    use Omnipay\Omnipay;
    use Omnipay\EasyPay\EasyPayGateway;

    $gateway = Omnipay::create(EasyPayGateway::class);
    $gateway->setMerchantId('12345678'); // E-Merchant unique ID provided by EasyPay after being integrated
    $gateway->setMerchantToken('8f11efa4-4041-4e28-a191-0cc01c4ff66c'); // Merchant token (key) provided by EasyPay after being integrated

```

3. Call purchase, it will automatically redirect to EasyPay's hosted page

```php

    $purchaseRequest = $gateway->purchase();
    $purchaseRequest->setTransactionId('123456'); // Order ID of the merchant system.
    $purchaseRequest->setAmount(5); // Transaction amount

```

4. Create a controller to handle the callback request. This URL merchant should provide EasyPay during registration.

```php

    $gateway = Omnipay::create(EasyPayGateway::class);
    $gateway->setMerchantId('12345678');
    $gateway->setMerchantToken('8f11efa4-4041-4e28-a191-0cc01c4ff66c');
    
    $fetchTransactionRequest = $gateway->fetchTransaction();
    $fetchTransactionRequest->setTransactionId('123456');

    $fetchTransactionResponse = $fetchTransactionRequest->send();
    
    if ($fetchTransactionResponse->isSuccessful()) {
        // Your logic is to mark the order as paid.
    }

```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/k3rnel/omnipay-easy-pay/issues),
or better yet, fork the library and submit a pull request.
