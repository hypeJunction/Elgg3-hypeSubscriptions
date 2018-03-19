<?php

namespace hypeJunction\Subscriptions;

use Elgg\Database\QueryBuilder;
use Elgg\Values;
use hypeJunction\Payments\Amount;
use hypeJunction\Payments\Product;

/**
 * Subscription plan
 *
 * @property string $plan_id Unique plan ID
 * @property string $interval
 * @property int    $interval_count
 * @property string $amount
 * @property string $currency
 * @property int    $trial_period_days
 */
class SubscriptionPlan extends Product {

	const SUBTYPE = 'subscription_plan';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		$id = $this->plan_id;
		if (elgg_language_key_exists("subscriptions:plan:$id")) {
			return elgg_echo("subscriptions:plan:$id");
		}

		return parent::getDisplayName();
	}

	/**
	 * Validate and set plan ID
	 *
	 * @param string $plan_id Desired plan id
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function setPlanId($plan_id) {
		if ($this->plan_id || !$plan_id) {
			return false;
		}

		$id = strtolower($plan_id);
		$id = preg_replace('/[^\p{L}\p{Nd}]+/', '_', $id);

		$guid = (int) $this->guid;

		$is_valid = elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function () use ($guid, $id) {
			$count = elgg_get_entities([
				'types' => 'object',
				'subtypes' => SubscriptionPlan::SUBTYPE,
				'count' => true,
				'wheres' => function (QueryBuilder $qb) use ($guid, $id) {
					$qb->joinMetadataTable('e', 'guid', 'plan_id', 'inner', 'plan_id');

					return $qb->merge([
						$qb->compare('e.guid', '!=', $guid, ELGG_VALUE_INTEGER),
						$qb->compare('plan_id.value', '=', $id, ELGG_VALUE_STRING),
					]);
				},
			]);

			return !$count;
		});

		if (!$is_valid) {
			$id .= '_' . rand(1000, 9999);
			$this->setPlanId($id);
		}

		$this->plan_id = $id;

		return true;
	}

	/**
	 * Get billing cycle name
	 * @return \stdClass|null
	 */
	public function getCycle() {
		$svc = elgg()->{'subscriptions.config'};
		/* @var $svc Config */

		$cycles = $svc->getCycles();

		foreach ($cycles as $name => $opts) {
			if ($opts->interval == $this->interval && $opts->interval_count == $this->interval_count) {
				$opts->cycle = $name;

				return $opts;
			}
		}
	}

	/**
	 * Set billing cycle
	 *
	 * @param string $cycle Cycle name
	 *
	 * @return void
	 */
	public function setCycle($cycle) {
		$svc = elgg()->{'subscriptions.config'};
		/* @var $svc Config */

		$cycles = $svc->getCycles();

		$cycle = elgg_extract($cycle, $cycles);

		$this->interval = $cycle->interval;
		$this->interval_count = $cycle->interval_count;
	}

	/**
	 * Subscribe user to this plan
	 *
	 * @param \ElggUser            $user    User
	 * @param \DateTime|int|string $current_period_end Subscription ends on this date, unless renewed
	 *
	 * @return Subscription
	 * @throws \Exception
	 */
	public function subscribe(\ElggUser $user, $current_period_end = null) {
		return elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function () use ($user, $current_period_end) {

			$subscription = new Subscription();
			$subscription->owner_guid = $user->guid;
			$subscription->container_guid = $this->guid;
			$subscription->access_id = ACCESS_PUBLIC;

			if ($current_period_end) {
				$subscription->current_period_end = Values::normalizeTimestamp($current_period_end);
			}

			if (!$subscription->save()) {
				return false;
			}

			return $subscription;
		});
	}
}
