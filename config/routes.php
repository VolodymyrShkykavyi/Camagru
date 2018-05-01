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

	'account/settings' => [
		'controller' => 'account',
		'action' => 'settings'
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
		'action' => 'index',
	],

	'gallery/page/([0-9]+)' => [
		'controller' => 'gallery',
		'action' => 'index',
	],

	'gallery/upload' => [
		'controller' => 'gallery',
		'action' => 'upload'
	],

	'gallery/upload/page/([0-9]+)' => [
		'controller' => 'gallery',
		'action' => 'upload'
	],

	'gallery/montage' => [
		'controller' => 'gallery',
		'action' => 'montage'
	],

	'gallery/image/([0-9]+)' => [
		'controller' => 'gallery',
		'action' => 'image'
	],

	'gallery/change/like' => [
		'controller' => 'gallery',
		'action' => 'changeLike'
	],

	'gallery/comment/add' => [
		'controller' => 'gallery',
		'action' => 'commentAdd'
	],

	'gallery/delete' => [
		'controller' => 'gallery',
		'action' => 'delete'
	],
);