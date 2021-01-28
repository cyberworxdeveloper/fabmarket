<?php
return [
    'backend' => [
        'frontName' => 'gshpk1pixofpqreo'
    ],
    'crypt' => [
        'key' => '695b62e1e7d45af8a0e7724c2b89672e'
    ],
    'db' => [
        'table_prefix' => 'mg_',
        'connection' => [
            'default' => [
                'host' => '3.6.21.143',
                'dbname' => 'fabmarket',
                'username' => 'fab',
                'password' => 'IFGlZTvoOl',
                'active' => '1',
                'driver_options' => [

                ]
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'default',
    'session' => [
        'save' => 'db'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => 'd2d_'
            ],
            'page_cache' => [
                'id_prefix' => 'd2d_'
            ]
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => ''
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'google_product' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'downloadable_domains' => [
        'www.fabmarket.in',
        'international-radio.s3.ap-south-1.amazonaws.com',
        's3.console.aws.amazon.com'
    ],
    'install' => [
        'date' => 'Thu, 05 Mar 2020 10:26:34 +0000'
    ]
];
