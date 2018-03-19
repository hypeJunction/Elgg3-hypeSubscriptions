<?php

namespace hypeJunction\Subscriptions;

use Elgg\EntityPermissionsException;
use Elgg\Request;

class AdminTaskGatekeeper {

	/**
	 * Restrict access to site/group administrators
	 *
	 * @param Request $request Request
	 *
	 * @return void
	 * @throws EntityPermissionsException
	 * @throws \Elgg\EntityNotFoundException
	 * @throws \Elgg\HttpException
	 * @throws \Exception
	 */
	public function __invoke(Request $request) {

		$guid = $request->getParam('guid');

		if (!$guid) {
			$guid = $request->getParam('container_guid');
		}

		elgg_entity_gatekeeper($guid);

		$container = get_entity($guid);

		if ($container instanceof SubscriptionPlan) {
			$container = $container->getContainerEntity();
		}

		if (!$container || !$container->canEdit()) {
			throw new EntityPermissionsException();
		}
	}
}