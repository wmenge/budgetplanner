<?php

return [
    'db' => [ 
    	'driver' => 'sqlite',
    	'database' => ':memory:'
    	'exec'	   => 'PRAGMA foreign_keys = ON;',
    	'options' => [ 'foreign_keys' => 'ON' ]
    ],
    'oauth2' => [
        'provider' => [
            'clientId'     => '<some client id>',
            'clientSecret' => '<some secret>',
            'redirectUri'  => '<some url>',
        ]
     ]
];
