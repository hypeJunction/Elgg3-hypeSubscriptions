<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;

class ConfigureContainerLogic {

	/**
	 * @elgg_plugin_hook container_logic_check object
	 *
	 * @param Hook $hook Hook
	 *
	 * @return bool|null
	 */
	public function __invoke(Hook $hook) {

		$container = $hook->getParam('container');
		$subtype = $hook->getParam('subtype');

		if ($subtype == Subscription::SUBTYPE && !$container instanceof SubscriptionPlan) {
			return false;
		}
	}
}