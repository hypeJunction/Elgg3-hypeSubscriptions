<?php

namespace hypeJunction\Subscriptions;

use DataFormatException;
use Elgg\BadRequestException;
use Elgg\EntityNotFoundException;
use Elgg\EntityPermissionsException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;

class SubscribeAction {

	/**
	 * Process payment and subscribe user to the plan
	 *
	 * @param Request $request Request
	 *
	 * @return ResponseBuilder
	 * @throws EntityNotFoundException
	 * @throws EntityPermissionsException
	 * @throws DataFormatException
	 * @throws BadRequestException
	 */
	public function __invoke(Request $request) {

		$plan = $request->getEntityParam('plan_guid');
		$user = $request->getUserParam('user_guid');
		$payment_method = $request->getParam('payment_method');

		if (!$payment_method) {
			throw new BadRequestException();
		}

		if (!$plan instanceof SubscriptionPlan) {
			throw new EntityNotFoundException();
		}

		if (!$user instanceof \ElggUser || !$user->canEdit()) {
			throw new EntityPermissionsException();
		}

		$plan_options = $request->getParam('plan_options');

		$svc = elgg()->subscriptions;
		/* @var $svc \hypeJunction\Subscriptions\SubscriptionsService */

		$subscriptions = $svc->getSubscriptions($user, $plan_options);

		$cancel = [];
		$add = true;

		foreach ($subscriptions as $subscription) {
			if ($subscription->container_guid != $plan->guid) {
				$cancel[] = $subscription;
			} else {
				$add = false;
			}
		}

		foreach ($cancel as $cancelled_subscription) {
			/* @var $cancelled_subscription \hypeJunction\Subscriptions\Subscription */

			if ($cancelled_subscription->cancel(false)) {
				// Cancels the subscription immediately
				system_message(
					elgg_echo('subscriptions:subscribe:cancel:success', [
						$cancelled_subscription->getContainerEntity()->getDisplayName()
					])
				);
			};
		}

		if (!$add) {
			return elgg_ok_response();
		}

		$gateway = $svc->getGateway($payment_method);
		/* @var $gateway RecurringPaymentGatewayInterface */

		$response = $gateway->subscribe($user, $plan, $request->getParams());

		if (!$response->getForwardURL() || $response->getForwardURL() === REFERRER) {
			$forward_url = elgg_generate_url('collection:object:subscription:owner', [
				'username' => $user->username,
			]);

			$response->setForwardURL($forward_url);
		}

		return $response;
	}
}