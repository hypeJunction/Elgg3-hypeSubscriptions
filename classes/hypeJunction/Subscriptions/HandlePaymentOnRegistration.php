<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;
use hypeJunction\Subscriptions\SubscriptionPlan;

class HandlePaymentOnRegistration {

	/**
	 * Handle payment on registration
	 *
	 * @elgg_plugin_hook register user
	 *
	 * @param Hook $hook Hook
	 *
	 * @return bool|null
	 * @throws \RegistrationException
	 */
	public function __invoke(Hook $hook) {

		if (!elgg_get_config('subscriptions.payment_on_registration')) {
			return null;
		}

		if ($hook->getValue() === false) {
			// something else prevented registration
			return false;
		}

		$user = $hook->getUserParam();

		if (!$user) {
			return null;
		}

		$params = _elgg_services()->request->getParams();

		$payment_method = elgg_extract('payment_method', $params);
		$plan_guid = elgg_extract('plan_guid', $params);
		$plan = get_entity($plan_guid);

		if (!$plan instanceof SubscriptionPlan) {
			register_error(elgg_echo("subscriptions:error:invalid_plan"));

			return false;
		}

		if (!$payment_method) {
			register_error(elgg_echo("subscriptions:error:payment_required"));

			return false;
		}

		$svc = elgg()->subscriptions;
		/* @var $svc \hypeJunction\Subscriptions\SubscriptionsService */

		$gateway = $svc->getGateway($payment_method);
		/* @var $gateway RecurringPaymentGatewayInterface */

		$response = $gateway->subscribe($user, $plan, $params);

		if ($response->getStatusCode() === 200) {
			$user->setValidationStatus(true, $payment_method);

			if ($response->getForwardURL() && $response->getForwardURL() !== REFERRER) {
				elgg_register_plugin_hook_handler('login:forward', 'user', function() use ($response) {
					return $response->getForwardURL();
				});
			}
		} else {
			return false;
		}
	}
}