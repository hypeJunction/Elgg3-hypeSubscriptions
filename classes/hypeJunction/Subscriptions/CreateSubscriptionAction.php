<?php

namespace hypeJunction\Subscriptions;

use Elgg\EntityNotFoundException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;
use Exception;

class CreateSubscriptionAction {

	/**
	 * Create a new subscription
	 *
	 * @param Request $request Request
	 *
	 * @return ResponseBuilder
	 * @throws EntityNotFoundException
	 * @throws Exception
	 */
	public function __invoke(Request $request) {

		$plan = $request->getEntityParam('container_guid');

		if (!$plan instanceof SubscriptionPlan) {
			throw new EntityNotFoundException();
		}

		$subscriber_guids = (array) $request->getParam('subscriber_guids');

		foreach ($subscriber_guids as $subscriber_guid) {
			$subscriber = get_entity($subscriber_guid);

			if (!$subscriber instanceof \ElggUser) {
				throw new EntityNotFoundException();
			}

			$subscription = $plan->subscribe($subscriber, $request->getParam('current_period_end'));

			$subscriptions[] = $subscription;
		}

		return elgg_ok_response([
			'subscriptions' => $subscriptions,
		], elgg_echo('subscriptions:create:success', [$plan->getDisplayName()]));

	}
}