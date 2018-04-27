<?php

return array(
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ],

	'index.php' => [
		'controller' => 'main',
		'action' => 'index'
	],

    'account/login' => [
        'controller' => 'account',
        'action' => 'login'
    ],

    'account/register' => [
        'controller' => 'account',
        'action' => 'register'
    ],

	'register' => [
		'controller' => 'account',
		'action' => 'register'
	],

    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout'
    ],

	'account/verify' => [
		'controller' => 'account',
		'action' => 'verify'
	],

	'register/validate' => [
		'controller' => 'account',
		'action' => 'registerValidate'
	],

	'gallery' => [
		'controller' => 'gallery',
		'action' => 'index'
	],

);