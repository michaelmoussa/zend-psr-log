<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Log\Logger' => new \ZendPsrLog\LoggerFactory('Zend\Log\Logger'),
            'ZendPsrLog\LoggerFactory' => function () {
                return new \ZendPsrLog\LoggerFactory('Zend\Log\Logger');
            }
        ),
    ),
);
