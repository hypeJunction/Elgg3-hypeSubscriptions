<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;
use Elgg\Router\Middleware\WalledGarden;

class SetupPaywalMiddleware {

	/**
	 * Enable site paywall on all routes
	 *
	 * @param Hook $hook Hook
	 *
	 * @return array|null
	 */
	public function __invoke(Hook $hook) {

		$config = $hook->getValue();

		$walled = elgg_extract('walled', $config, true);

		if ($walled === false) {
			// Do not enable paywall on public routes
			return null;
		}

		$middleware = elgg_extract('middleware', $config, []);

		$middleware[] = SitePaywallMiddleware::class;

		$config['middleware'] = $middleware;

		return $config;
	}
}