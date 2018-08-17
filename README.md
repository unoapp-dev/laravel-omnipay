Omnipay for Laravel 5 & Lumen
==============

[![Total Downloads](https://img.shields.io/packagist/dt/ignited/laravel-omnipay.svg)](https://packagist.org/packages/ignited/laravel-omnipay)
[![Latest Version](http://img.shields.io/packagist/v/ignited/laravel-omnipay.svg)](https://github.com/ignited/laravel-omnipay/releases)
[![Dependency Status](https://www.versioneye.com/php/ignited:laravel-omnipay/badge.svg)](https://www.versioneye.com/php/ignited:laravel-omnipay)

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel 5 via a ServiceProvider to make Configuring multiple payment tunnels a breeze!

### Laravel 4 Support

For Laravel 4 see the [version 1.x](https://github.com/ignited/laravel-omnipay/tree/1.1.0) tree

### Now using Omnipay 2.3/2.5
 
Version `2.0` and onwards has been updated to use Omnipay 2.3.

Version `2.2` and onwards is using Omnipay 2.5

Version `2.3` and onwards supports Laravel 5.4

### Composer Configuration

**Important Note: Compatibility with Symfony 3 Event Dispatcher**

If you are using Symfony 3 (or Symfony 3 components), please note that Omnipay 2.x still relies on Guzzle3, which in turn depends on symfony/event-dispatcher 2.x. This conflicts with Symfony 3 (standard install), so cannot be installed. Development for Omnipay 3.x is still in progress at the moment.

If you are just using the Symfony 3 components (eg. stand-alone or Silex/Laravel etc), you could try to force the install of symfony/event-dispatcher:^2.8, which is compatible with both Symfony 3 components and Guzzle 3.

```
composer require symfony/event-dispatcher:^2.8
```

Include the laravel-omnipay package as a dependency in your `composer.json`:

    "unoapp-dev/laravel-omnipay": "^2.*"
    
**Note:** You don't need to include the `omnipay/common` in your composer.json - it is a requirement of the `laravel-omnipay` package.

### Installation

Run `composer install` to download the dependencies.

#### Laravel 5

Add a ServiceProvider to your providers array in `config/app.php`:

```php
'providers' => [

	'Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider',

]
```

Add the `Omnipay` facade to your facades array:

```php
	'Omnipay' => 'Ignited\LaravelOmnipay\Facades\OmnipayFacade',
```

Finally, publish the configuration files:

```
php artisan vendor:publish --provider="Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider" --tag=config
```

#### Lumen

For `Lumen` add the following in your bootstrap/app.php
```php
$app->register(Ignited\LaravelOmnipay\LumenOmnipayServiceProvider::class);
```

Copy the laravel-omnipay.php file from the config directory to config/laravel-omnipay.php

And also add the following to bootstrap/app.php
```php
$app->configure('laravel-omnipay');
```

### Configuration

Once you have published the configuration files, you can add your gateway options to the config file in `config/laravel-omnipay.php`.

#### Moneris Example
Here is an example of how to configure merchant id & merchant key with moneris driver

```php
...
'gateways' => [
    'moneris' => [
        'driver' => 'Moneris',
        'options' => [
            'merchantId' => env('MONERIS_MERCHANT_ID', ''),
            'merchantKey' => env('MONERIS_MERCHANT_KEY', ''),
            'testMode' => env('MONERIS_TEST_MODE', '')
        ]
    ]
]
...
```


### Usage

```php
$cardInput = [
    'firstName'   => 'John',
    'lastName'    => 'Doe',
    'number'      => '4242424242424242',
    'expiryMonth' => '03',
    'expiryYear'  => '2025',
    'cvv'         => '123',
    'billingAddress1' => '795 Folsom Ave, Suite 600',
    'billingCity' => 'San Francisco',
    'billingPostcode' => '94107',
    'billingState' => 'California',
    'billingCountry' => 'United States',
    'billingPhone' => '(555) 539-1037',
    'email' => 'john.doe@example.com'
];


# 1. Generate payment profile :
$createcardResponse = Omnipay::createCard(['card' => $cardInput])->send();


# 2. Delete payment profile :
$cardParams = [
    'cardReference' => $createcardResponse->getCardReference()
];

$deletecardResponse = Omnipay::deleteCard($cardParams)->send();


# 3. Purchase (using payment profile) :
$purchaseParams = [
    "amount" => 100,
    "order_number" => 11111,
    "payment_method" => 'payment_profile',
    "cardReference" => $createcardResponse->getCardReference() 
];

$purchaseResponse = Omnipay::purchase($purchaseParams)->send();


# 4. Refund :
$refundParams = [
   'amount' => 100,
   'transactionReference' => $purchaseResponse->getData()
];

$refundResponse = Omnipay::refund($refundParams)->send();
```
    
This will use the gateway specified in the config as `default`.

However, you can also specify a gateway to use.

```php
Omnipay::setGateway('moneris');
```
    
In addition you can take an instance of the gateway.

```php
$gateway = Omnipay::getGateway('moneris');
```
