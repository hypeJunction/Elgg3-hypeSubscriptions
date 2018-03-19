<?php

namespace hypeJunction\Subscriptions;

use Elgg\PluginHooksService;

class Config {

	/**
	 * Constructor
	 *
	 * @param PluginHooksService $hooks Hooks
	 */
	public function __construct(PluginHooksService $hooks) {
		$this->hooks = $hooks;
	}

	/**
	 * Get billing cycles config
	 * @return array
	 */
	public function getCycles() {

		$cycles = [
			'daily' => (object) [
				'interval' => 'day',
				'interval_count' => 1,
				'label' => elgg_echo('subscription:cycle:daily'),
			],
			'weekly' => (object) [
				'interval' => 'week',
				'interval_count' => 1,
				'label' => elgg_echo('subscription:cycle:weekly'),
			],
			'biweekly' => (object) [
				'interval' => 'week',
				'interval_count' => 2,
				'label' => elgg_echo('subscription:cycle:biweekly'),
			],
			'monthly' => (object) [
				'interval' => 'month',
				'interval_count' => 1,
				'label' => elgg_echo('subscription:cycle:monthly'),
			],
			'bimonthly' => (object) [
				'interval' => 'month',
				'interval_count' => 2,
				'label' => elgg_echo('subscription:cycle:bimonthly'),
			],
			'quarterly' => (object) [
				'interval' => 'month',
				'interval_count' => 3,
				'label' => elgg_echo('subscription:cycle:quarterly'),
			],
			'yearly' => (object) [
				'interval' => 'year',
				'interval_count' => 1,
				'label' => elgg_echo('subscription:cycle:yearly'),
			],
		];

		return $this->hooks->trigger('cycles', 'subscriptions', null, $cycles);
	}
}