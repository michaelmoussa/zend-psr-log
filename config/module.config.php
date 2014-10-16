<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Log\Logger' => 'ZendPsrLog\LoggerFactory'
        ),
    ),
);
