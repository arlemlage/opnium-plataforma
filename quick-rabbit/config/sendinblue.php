<?php
$jsonString = file_get_contents('assets/json/smtp.json');
$smtp_info = json_decode($jsonString,true);

return [
    /*
     * ----------------------------------------------------
     * Sendinblue Credentials
     * ----------------------------------------------------
     *
     * This option specifies the Sendinblue credentials for
     * your account. You can put it here but I strongly
     * recommend to put thoses settings into your
     * .env & .env.example file.
     *
     */
    'apikey' => $smtp_info['api_key'],
    'partnerkey' => env('SENDINBLUE_PARTNERKEY', null),
];
