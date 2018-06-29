<?php

return [
	'bootstrap' => \hypeJunction\Activity\Bootstrap::class,

	'routes' => [
		'collection:river:owner' => [
			'path' => '/activity/owner/{username}',
			'resource' => 'activity/owner',
		],
		'collection:river:friends' => [
			'path' => '/activity/friends/{username?}',
			'resource' => 'activity/friends',
		],
		'collection:river:group' => [
			'path' => '/activity/group/{guid}',
			'resource' => 'activity/group',
		],
		'collection:river:all' => [
			'path' => '/activity/all',
			'resource' => 'activity/all',
		],
		'default:river' => [
			'path' => '/activity',
			'resource' => 'activity/all',
		],
		'view:user' => [
			'path' => '/profile/{username}',
			'resource' => 'activity/owner',
		],
		'view:user:user' => [
			'path' => '/profile/{username}',
			'resource' => 'activity/owner',
		],
		'view:group' => [
			'path' => '/groups/profile/{guid}/{title?}',
			'resource' => 'activity/group',
		],
		'view:group:group' => [
			'path' => '/groups/profile/{guid}/{title?}',
			'resource' => 'activity/group',
		],
	],
];
