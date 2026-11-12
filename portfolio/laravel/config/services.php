<?php

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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'whatsapp' => [
        'token' => env('WHATSAPP_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'owner_number' => env('WHATSAPP_OWNER_NUMBER'),
        'greeting_template' => env('WHATSAPP_GREETING_TEMPLATE', 'ariodevs'),
        'owner_template' => env('WHATSAPP_OWNER_TEMPLATE', 'ariodevs'),
        'language' => env('WHATSAPP_TEMPLATE_LANGUAGE', 'en'),
    ],

    'publication_import' => [
        'token' => env('PUBLICATION_IMPORT_TOKEN'),
    ],

    'publications_admin' => [
        'username' => env('PUBLICATIONS_ADMIN_USERNAME'),
        'password_hash' => env('PUBLICATIONS_ADMIN_PASSWORD_HASH'),
    ],

];
