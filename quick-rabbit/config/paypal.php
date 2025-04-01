<?php
$paypal_json = file_get_contents('assets/json/paypal.json');
$paypal_info = json_decode($paypal_json,true);

return [
    'mode'    => $paypal_info['paypal_active_mode'], // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'client_id'         => $paypal_info['paypal_client_id'],
        'client_secret'     => $paypal_info['paypal_client_secret'],
        'app_id'            => $paypal_info['paypal_app_id'],
    ],
    'live' => [
        'client_id'         => $paypal_info['paypal_client_id'],
        'client_secret'     => $paypal_info['paypal_client_secret'],
        'app_id'            => $paypal_info['paypal_app_id'],
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
    'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
];
