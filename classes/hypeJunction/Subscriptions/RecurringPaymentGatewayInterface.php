<?php

namespace hypeJunction\Subscriptions;

use Elgg\Http\ResponseBuilder;
use hypeJunction\Payments\GatewayInterface;

interface RecurringPaymentGatewayInterface extends GatewayInterface {

	/**
	 * Returns ID of the gateway
	 * @return string
	 */
	public function id();

	/**
	 * Start a recurring payment
	 *
	 * @param \ElggUser        $user   User
	 * @param SubscriptionPlan $plan   Plan
	 * @param array            $params Request parameters
	 *
	 * @return ResponseBuilder
	 */
	public function subscribe(\ElggUser $user, SubscriptionPlan $plan, array $params = []);

	/**
	 * Cancel subscription
	 *
	 * @param Subscription $subscription Subscription
	 * @param array        $params       Request parameters
	 *
	 * @return bool
	 */
	public function cancel(Subscription $subscription, array $params = []);
}