<?php

return [
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'subscription',
			'class' => \hypeJunction\Subscriptions\Subscription::class,
		],
		[
			'type' => 'object',
			'subtype' => 'subscription_plan',
			'class' => \hypeJunction\Subscriptions\SubscriptionPlan::class,
		],
	],
	'actions' => [
		'subscriptions/create' => [
			'controller' => \hypeJunction\Subscriptions\CreateSubscriptionAction::class,
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
		],
		'subscriptions/cancel' => [
			'controller' => \hypeJunction\Subscriptions\CancelSubscriptionAction::class,
		],
		'subscriptions/subscribe' => [
			'controller' => \hypeJunction\Subscriptions\SubscribeAction::class,
		],
		'hypeSubscriptions/settings/save' => [
			'controller' =>\hypeJunction\Subscriptions\SavePluginSettings::class,
			'access' => 'admin',
		],
	],
	'routes' => [
		'add:object:subscription_plan' => [
			'path' => '/subscriptions/plans/add/{guid}',
			'resource' => 'post/add',
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
			'defaults' => [
				'guid' => elgg_get_site_entity()->guid,
				'type' => 'object',
				'subtype' => 'subscription_plan',
			],
		],
		'edit:object:subscription_plan' => [
			'path' => '/subscriptions/plans/edit/{guid}',
			'resource' => 'post/edit',
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
		],
		'view:object:subscription_plan' => [
			'path' => '/subscriptions/plans/view/{guid}',
			'resource' => 'post/view',
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
		],
		'collection:object:subscription_plan:all' => [
			'path' => '/subscriptions/plans/all',
			'resource' => 'collection/all',
			'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
			'defaults' => [
				'guid' => elgg_get_site_entity()->guid,
			],
		],
		'collection:object:subscription_plan:site' => [
			'path' => '/subscriptions/plans/site/{guid}',
			'resource' => 'collection/group',
			'middleware' => [
				\Elgg\Router\Middleware\AdminGatekeeper::class,
			],
			'defaults' => [
				'guid' => elgg_get_site_entity()->guid,
			],
		],
		'collection:object:subscription_plan:group' => [
			'path' => '/subscriptions/plans/group/{guid}',
			'resource' => 'collection/group',
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
		],

		'add:object:subscription' => [
			'path' => '/subscriptions/subscribers/add/{guid}',
			'resource' => 'subscriptions/create',
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
		],
		'collection:object:subscription:all' => [
			'path' => '/subscriptions/subscribers/all/{guid}',
			'resource' => 'collection/group',
			'middleware' => [
				\hypeJunction\Subscriptions\AdminTaskGatekeeper::class,
			],
		],
		'collection:object:subscription:owner' => [
			'path' => '/settings/subscriptions/{username}',
			'resource' => 'collection/owner',
			'middleware' => [
				\hypeJunction\Subscriptions\PrivateContentGatekeeper::class,
			],
		],

		'subscriptions:subscribe:plan' => [
			'path' => '/settings/subscriptions/subscribe/{guid}',
			'resource' => 'subscriptions/subscribe/plan',
		],
		'subscriptions:subscribe:site' => [
			'path' => '/settings/subscriptions/subscribe/site',
			'resource' => 'subscriptions/subscribe/site',
			'walled' => false,
		],
	],
];
