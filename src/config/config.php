<?php

return [

    // The default gateway to use
    'default' => 'beanstream',

    // Add in each gateway here
    'gateways' => [

        'beanstream' => [
            'driver' => 'Beanstream',
            'options' => [
                'merchantId' => env('BEANSTREAM_MERCHANT_ID', ''),
                'profilePasscode' => env('BEANSTREAM_PROFILE_PASSCODE', ''),
                'transactionPasscode' => env('BEANSTREAM_TRANSACTION_PASSCODE', ''),
                'testMode' => env('BEANSTREAM_TEST_MODE', '')
            ]
        ],

        'moneris' => [
            'driver' => 'Moneris',
            'options' => [
                'merchantId' => env('MONERIS_MERCHANT_ID', ''),
                'merchantKey' => env('MONERIS_MERCHANT_KEY', ''),
                'testMode' => env('MONERIS_TEST_MODE', '')
            ]
        ],

        'vantiv' => [
            'driver' => 'Vantiv',
            'options' => [
                'username' => env('VANTIV_USERNAME', ''),
                'password' => env('VANTIV_PASSWORD', ''),
                'testMode' => env('VANTIV_TEST_MODE', '')
            ]
        ],

        'payeezy' => [
            'driver' => 'Payeezy',
            'options' => [
                'apiKey' => env('PAYEEZY_API_KEY', ''),
                'apiSecret' => env('PAYEEZY_API_SECRET', ''),
                'merchantToken' => env('PAYEEZY_MERCHANT_TOKEN', ''),
                'testMode' => env('PAYEEZY_TEST_MODE', '')
            ]
        ]
    ]
];