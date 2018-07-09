<?php

/**
 * Subscriptions
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 */
require_once __DIR__ . '/autoloader.php';

return function () {
	if (elgg_get_config('subscriptions.site_paywall')) {
		elgg_register_plugin_hook_handler('route:config', 'all', \hypeJunction\Subscriptions\SetupPaywalMiddleware::class, 999);
	}

	elgg_register_event_handler('init', 'system', function () {

		elgg_extend_view('elements/components.css', 'subscriptions.css');
		
		elgg_register_plugin_hook_handler('fields', 'object:subscription_plan', \hypeJunction\Subscriptions\SubscriptionPlanFields::class);

		elgg_register_collection('collection:object:subscription_plan:all', \hypeJunction\Subscriptions\PlanCollection::class);
		elgg_register_collection('collection:object:subscription_plan:site', \hypeJunction\Subscriptions\SitePlanCollection::class);
		elgg_register_collection('collection:object:subscription_plan:group', \hypeJunction\Subscriptions\GroupPlanCollection::class);
		elgg_register_collection('collection:object:subscription:all', \hypeJunction\Subscriptions\SubscriberCollection::class);
		elgg_register_collection('collection:object:subscription:owner', \hypeJunction\Subscriptions\UserSubscriptionsCollection::class);

		elgg_register_plugin_hook_handler('uses:comments', 'object:subscription_plan', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:likes', 'object:subscription_plan', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:autosave', 'object:subscription_plan', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:river', 'object:subscription_plan', [\Elgg\Values::class, 'getFalse']);

		elgg_register_plugin_hook_handler('uses:comments', 'object:subscription', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:likes', 'object:subscription', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:autosave', 'object:subscription', [\Elgg\Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:river', 'object:subscription', [\Elgg\Values::class, 'getFalse']);

		elgg_register_plugin_hook_handler('permissions_check', 'object', \hypeJunction\Subscriptions\ConfigureEditPermissions::class);
		elgg_register_plugin_hook_handler('permissions_check:delete', 'object', \hypeJunction\Subscriptions\ConfigureDeletePermissions::class);
		elgg_register_event_handler('delete', 'object', \hypeJunction\Subscriptions\OnDeleteEvent::class, 1);

		elgg_register_plugin_hook_handler('container_logic_check', 'object', \hypeJunction\Subscriptions\ConfigureContainerLogic::class);

		elgg_register_plugin_hook_handler('register', 'menu:entity', \hypeJunction\Subscriptions\EntityMenu::class);
		elgg_register_plugin_hook_handler('register', 'menu:page', \hypeJunction\Subscriptions\PageMenu::class);

		elgg_register_plugin_hook_handler('create', 'object', \hypeJunction\Subscriptions\NotifySubscriptionStart::class);
		elgg_register_plugin_hook_handler('cancel', 'subscription', \hypeJunction\Subscriptions\NotifySubscriptionCancel::class);

		elgg_register_plugin_hook_handler('register', 'user', \hypeJunction\Subscriptions\HandlePaymentOnRegistration::class, 100);

		elgg_extend_view('register/extend', 'subscriptions/register/extend');
	});
};
