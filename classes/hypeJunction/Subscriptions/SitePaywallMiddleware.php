<?php

namespace hypeJunction\Subscriptions;

use DataFormatException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;

class SitePaywallMiddleware {

	/**
	 * Validate that route is accessible with user's current subscription
	 *
	 * @param Request $request Request
	 *
	 * @return void
	 * @throws SitePaywallException
	 * @throws DataFormatException
	 */
	public function __invoke(Request $request) {

		$svc = elgg()->subscriptions;
		/* @var $svc \hypeJunction\Subscriptions\SubscriptionsService */

		if ($request->isXhr()) {
			return;
		}

		$user = elgg_get_logged_in_user_entity();
		if (!$user) {
			// Let walled garden control what resources are accessible
			// when the user is logged out
			return;
		}

		if ($user->isAdmin()) {
			return;
		}

		$exempt = ['settings'];

		$path = trim($request->getPath(), '/');
		$segments = explode('/', $path);
		$identifier = array_shift($segments);

		if (in_array($identifier, $exempt)) {
			return;
		}

		$can_access = $svc->hasSiteSubscription($user);

		if (!elgg_trigger_plugin_hook('paywall:route', $request->getRoute(), ['request' => $request], $can_access)) {
			$exception = new SitePaywallException();
			$exception->setParams($request->getParams());
			$exception->setRedirectUrl(elgg_generate_url('subscriptions:subscribe:site'));
			throw $exception;
		}
	}
}