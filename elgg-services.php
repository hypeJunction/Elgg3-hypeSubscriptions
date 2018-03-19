<?php

return [
	'subscriptions.config' => \DI\object(\hypeJunction\Subscriptions\Config::class)
		->constructor(\DI\get('hooks')),

	'subscriptions' => \DI\object(\hypeJunction\Subscriptions\SubscriptionsService::class)
		->constructor(\DI\get('subscriptions.config')),

];