<?php
$firebase_json = file_get_contents('assets/json/firebase.json');
$firebase_info = json_decode($firebase_json,true);

$social_json = file_get_contents('assets/json/social.json');
$social_info = json_decode($social_json,true);

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'firebase' => [
        'api_key' => $firebase_info['api_key'],
        'auth_domain' => $firebase_info['auth_domain'],
        'project_id' => $firebase_info['project_id'],
        'database_url' => $firebase_info['database_url'],
        'storage_bucket' => $firebase_info['storage_bucket'],
        'messaging_sender_id' => $firebase_info['messaging_sender_id'],
        'app_id' => $firebase_info['app_id'],
        'measurement_id' => $firebase_info['measurement_id']
    ],

    'google' => [
        'client_id' => $social_info['google_client_id'],
        'client_secret' => $social_info['google_client_secret'],
        'redirect' => $social_info['redirect_base_url'].'/auth/google/callback'
    ],

    'github' => [
        'client_id' => $social_info['github_client_id'],
        'client_secret' => $social_info['github_client_secret'],
        'redirect' => $social_info['redirect_base_url'].'/auth/github/callback'
    ],

    'linkedin' => [
        'client_id' => $social_info['linkedin_client_id'],
        'client_secret' => $social_info['linkedin_client_secret'],
        'redirect' => $social_info['redirect_base_url'].'/auth/linkedin/callback'
    ],
    'envato' => [
        'client_id' => $social_info['envato_client_id'],
        'client_secret' => $social_info['envato_client_secret'],
        'redirect' =>  $social_info['redirect_base_url'].'/auth/envato/callback'
    ],

];
