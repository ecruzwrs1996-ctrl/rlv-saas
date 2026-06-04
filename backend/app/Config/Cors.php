<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    public array $default = [

        'allowedOrigins' => [

            'http://localhost:8081',
        ],

        'allowedOriginsPatterns' => [],

        'supportsCredentials' => true,

        'allowedHeaders' => [

            'Content-Type',
            'Authorization',
            'X-Requested-With',
        ],

        'exposedHeaders' => [
            'Content-Disposition',
        ],

        'allowedMethods' => [

            'GET',
            'POST',
            'PUT',
            'DELETE',
            'OPTIONS',
        ],

        'maxAge' => 3600,
    ];
}