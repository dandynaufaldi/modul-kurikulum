<?php

use Phalcon\Config;

return new Config(
    [
        'database' => [
            'adapter' => getenv('KUR_DB_ADAPTER'),
            'host' => getenv('KUR_DB_HOST'),
            'username' => getenv('KUR_DB_USERNAME'),
            'password' => getenv('KUR_DB_PASSWORD'),
            'dbname' => getenv('KUR_DB_NAME'),
        ], 

        'mail' => [
            'driver' => getenv('KUR_MAIL_DRIVER'),
            'cacheDir' => APP_PATH . "/cache/mail/",
            'fromName' => getenv('KUR_MAIL_FROM_NAME'),
            'fromEmail' => getenv('KUR_MAIL_FROM_EMAIL'),
            'smtp' => [
                'server'    => getenv('KUR_MAIL_SMTP_HOST'),
                'port'      => getenv('KUR_MAIL_SMTP_PORT'),
                'username'  => getenv('KUR_MAIL_SMTP_USERNAME'),
                'password'  => getenv('KUR_MAIL_SMTP_PASSWORD'),
                'encryption' => getenv('KUR_MAIL_SMTP_ENCRYPTION')
            ],
        ],
    ]
);
