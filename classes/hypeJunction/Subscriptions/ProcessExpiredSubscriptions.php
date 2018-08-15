<?php

namespace hypeJunction\Subscriptions;

use Elgg\Database\QueryBuilder;
use Elgg\Hook;

class ProcessExpiredSubscriptions {

	/**
	 * Process expired subscriptions
	 *
	 * @elgg_plugin_hook cron hourly
	 *
	 * @param Hook $hook Hook
	 * @return void
	 */
	public function __invoke(Hook $hook) {

		elgg_call(ELGG_IGNORE_ACCESS, function() {
			$subscriptions = elgg_get_entities([
				'types' => 'object',
				'subtypes' => Subscription::SUBTYPE,
				'metadata_name_value_pairs' => [
					[
						'name' => 'current_period_end',
						'value' => time(),
						'operand' => '<=',
					],
					[
						'name' => 'cancelled_at',
						'value' => time(),
						'operand' => '<=',
					],
				],
				'wheres' => function(QueryBuilder $qb) {
					$qb->joinMetadataTable('e', 'guid', 'expired', 'left', 'expired');

					return $qb->merge([
						$qb->compare('expired.value', 'IS NULL'),
						$qb->compare('expired.value', '=', 0, ELGG_VALUE_INTEGER),
					], 'OR');
				},
				'batch' => true,
				'batch_inc_offset' => false,
				'limit' => 0,
			]);

			foreach ($subscriptions as $subscription) {
				if (elgg_trigger_event('expire', 'subscription', $subscription)) {
					$subscription->expired = true;
				}
			}
		});
	}
}