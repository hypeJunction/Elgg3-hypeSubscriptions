<?php

namespace hypeJunction\Subscriptions;

use Elgg\EntityNotFoundException;
use Elgg\EntityPermissionsException;
use Elgg\Request;

class CancelSubscriptionAction {

	public function __invoke(Request $request) {

		$entity = $request->getEntityParam();

		if (!$entity instanceof Subscription) {
			throw new EntityNotFoundException();
		}

		if (!$entity->canEdit()) {
			throw new EntityPermissionsException();
		}

		if ($entity->cancel()) {
			return elgg_ok_response([
				'entity' => $entity,
			], elgg_echo('subscriptions:cancel:success'));
		}

		return elgg_error_response(elgg_echo('subscriptions:cancel:error'));
	}
}