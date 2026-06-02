<?php

use Illuminate\Support\Facades\File;

return [
    'icon' => 'assets/horizontal-logo.svg',

    //    'background' => 'assets/logo.svg',

    'support_url' => 'https://teams.live.com/l/invite/FEALDqx1XC04nCUHQE',

    'server' => [
        'php'       => [
            'name'    => 'PHP Version',
            'version' => '>= 8.1.0',
            'check'   => true
        ],
        'pdo'       => [
            'name'  => 'PDO',
            'check' => true
        ],
        'mbstring'  => [
            'name'  => 'Mbstring extension',
            'check' => true
        ],
        'fileinfo'  => [
            'name'  => 'Fileinfo extension',
            'check' => true
        ],
        'openssl'   => [
            'name'  => 'OpenSSL extension',
            'check' => true
        ],
        'tokenizer' => [
            'name'  => 'Tokenizer extension',
            'check' => true
        ],
        'json'      => [
            'name'  => 'Json extension',
            'check' => true
        ],
        'curl'      => [
            'name'  => 'Curl extension',
            'check' => true
        ],
        'zip'       => [
            'name'  => 'Zip extension',
            'check' => true
        ]
    ],

    'folders' => [
        'storage.framework' => [
            'name'  => base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'framework',
            'check' => true
        ],
        'storage.logs'      => [
            'name'  => base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs',
            'check' => true
        ],
        'storage.cache'     => [
            'name'  => base_path() . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'cache',
            'check' => true
        ],
    ],

    'database' => [
        'seeders' => false
    ],

    'commands' => [
        'db:seed --class=InstallationSeeder',
        'db:seed --class=AddSuperAdminSeeder',
    ],

    'admin_area' => [
        'user' => [
            'email'    => 'superadmin@gmail.com',
            'password' => 'superadmin'
        ]
    ]
];
