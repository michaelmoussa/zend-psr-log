<?php
return [
    'service_manager' => [
        'factories' => [
            'Zend\Log\Logger' => 'ZendPsrLog\LoggerFactory'
        ],
    ],
];
