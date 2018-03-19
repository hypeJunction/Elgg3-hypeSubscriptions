<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;

class ConfigureEditPermissions {

	/**
	 * @elgg_plugin_hook permissions_check object
	 *
	 * @param Hook $hook
	 *
	 * @return bool
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();
		
	}
}