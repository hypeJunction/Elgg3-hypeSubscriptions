<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;

class ConfigureDeletePermissions {

	/**
	 * @elgg_plugin_hook permissions_check:delete object
	 *
	 * @param Hook $hook
	 *
	 * @return bool
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();

		if ($entity instanceof Subscription) {
			// Do not allow subscriptions to be deleted
			return false;
		}

	}
}