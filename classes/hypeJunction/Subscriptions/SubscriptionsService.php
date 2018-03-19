<?php

namespace hypeJunction\Subscriptions;

use Elgg\Database\QueryBuilder;
use Elgg\Database\Repository;
use Elgg\TimeUsing;
use Elgg\Values;
use ElggUser;
use hypeJunction\Lists\CollectionInterface;
use hypeJunction\Payments\GatewayInterface;

class SubscriptionsService {

	use TimeUsing;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var RecurringPaymentGatewayInterface[]
	 */
	protected $gateways;

	/**
	 * Constructor
	 *
	 * @param Config $config Config
	 */
	public function __construct(Config $config) {
		$this->config = $config;
	}

	/**
	 * Register a payment gateway
	 *
	 * @param RecurringPaymentGatewayInterface $gateway Gateway
	 *
	 * @return void
	 */
	public function registerGateway(RecurringPaymentGatewayInterface $gateway) {
		$this->gateways[$gateway->id()] = $gateway;
	}

	/**
	 * Get a gateway by its ID
	 *
	 * @param string $id ID
	 *
	 * @return GatewayInterface|null
	 */
	public function getGateway($id) {
		return elgg_extract($id, $this->gateways);
	}

	/**
	 * Get registered gateways
	 * @return GatewayInterface[]
	 */
	public function getGateways() {
		return array_values($this->gateways);
	}

	/**
	 * Get all plans created within a target
	 *
	 * @param \ElggEntity $target Target site or group
	 *
	 * @return Repository
	 */
	public function getPlans(\ElggEntity $target = null) {
		if (!isset($target)) {
			$target = elgg_get_site_entity();
		}

		if ($target instanceof \ElggSite) {
			$collection = elgg_get_collection('collection:object:subscription_plan:site', $target);
		} else {
			$collection = elgg_get_collection('collection:object:subscription_plan:group', $target);
		}

		return $collection->getList();
	}

	/**
	 * Check if user is subscribed to a plan
	 *
	 * @param SubscriptionPlan $plan Plan
	 * @param ElggUser         $user User
	 *
	 * @return bool
	 */
	public function hasPlan(SubscriptionPlan $plan, ElggUser $user = null) {

		if (!isset($user)) {
			$user = elgg_get_logged_in_user_entity();
		}

		if (!$user) {
			return false;
		}

		$subscriptions = elgg_get_entities([
			'types' => 'object',
			'subtypes' => Subscription::SUBTYPE,
			'limit' => 0,
			'wheres' => function (QueryBuilder $qb) use ($user, $plan) {
				$qb->joinMetadataTable('e', 'guid', 'current_period_end', 'inner', 'current_period_end');

				return $qb->merge([
					$qb->compare('e.owner_guid', '=', $user->guid, ELGG_VALUE_GUID),
					$qb->compare('e.container_guid', '=', $plan->guid, ELGG_VALUE_GUID),
					$qb->compare('current_period_end.value', '>', $this->getCurrentTime(), ELGG_VALUE_TIMESTAMP),
				]);
			},
		]);

		return $subscriptions ? $subscriptions[0] : false;
	}

	/**
	 * Check if user has a site membership plan
	 *
	 * @param ElggUser|null $user User
	 *
	 * @return bool
	 * @throws \DataFormatException
	 */
	public function hasSiteSubscription(ElggUser $user = null) {
		$subscriptions = $this->getSiteSubscriptions($user, ['count' => true]);

		return !empty($subscriptions);
	}

	/**
	 * Check if user has a site membership plan
	 *
	 * @param ElggUser|null $user    User
	 * @param array         $options Additional ege* options
	 *
	 * @return Subscription[]|false
	 * @throws \DataFormatException
	 */
	public function getSiteSubscriptions(ElggUser $user = null, array $options = []) {
		$plans = elgg_get_config('subscriptions.site_membership_plans');
		$plans = Values::normalizeGuids($plans);

		if (empty($plans)) {
			return false;
		}

		return $this->getSubscriptions($user, $plans, $options);
	}

	/**
	 * Check if user has a subscription plan
	 *
	 * @param ElggUser|null $user    User
	 * @param mixed         $plans   Specific subscription plans to check against
	 * @param array         $options Additional ege* options
	 *
	 * @return Subscription[]|false
	 * @throws \DataFormatException
	 */
	public function getSubscriptions(ElggUser $user = null, $plans = null, array $options = []) {
		$plans = Values::normalizeGuids($plans);

		if (!isset($user)) {
			$user = elgg_get_logged_in_user_entity();
		}

		$defaults = [
			'types' => 'object',
			'subtypes' => Subscription::SUBTYPE,
			'limit' => 0,
			'wheres' => function (QueryBuilder $qb) use ($user, $plans) {
				$qb->joinMetadataTable('e', 'guid', 'current_period_end', 'inner', 'current_period_end');

				return $qb->merge([
					$qb->compare('e.owner_guid', '=', (int) $user->guid, ELGG_VALUE_GUID),
					!empty($plans) ? $qb->compare('e.container_guid', 'IN', $plans, ELGG_VALUE_GUID) : null,
					$qb->compare('current_period_end.value', '>', $this->getCurrentTime(), ELGG_VALUE_TIMESTAMP),
				]);
			},
		];

		$options = array_merge($defaults, $options);

		$subscriptions = elgg_get_entities($options);

		return $subscriptions;
	}

	/**
	 * Check if user has a subscription
	 *
	 * @param ElggUser|null $user  User
	 * @param mixed         $plans Subscription plans to check against
	 *
	 * @return bool
	 * @throws \DataFormatException
	 */
	public function hasSubscription(ElggUser $user = null, $plans = null) {
		$subscriptions = $this->getSubscriptions($user, ['count' => true]);

		return !empty($subscriptions);
	}
}