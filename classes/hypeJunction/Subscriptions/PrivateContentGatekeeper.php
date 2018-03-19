<?php

namespace hypeJunction\Subscriptions;

use Elgg\EntityPermissionsException;
use Elgg\Request;

class PrivateContentGatekeeper {

	/**
	 * Restrict access to site/group administrators
	 *
	 * @param Request $request Request
	 *
	 * @return void
	 * @throws EntityPermissionsException
	 */
	public function __invoke(Request $request) {

		$user = $request->getUserParam('username');

		if (!$user || !$user->canEdit()) {
			throw new EntityPermissionsException();
		}
	}
}