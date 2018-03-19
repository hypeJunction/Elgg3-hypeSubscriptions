<?php

namespace hypeJunction\Subscriptions;

use Elgg\Event;

class OnDeleteEvent {

	/**
	 * @elgg_event delete object
	 *
	 * @param Event $event Event
	 * @return bool
	 */
	public function __invoke(Event $event) {

		$object = $event->getObject();

		if ($object instanceof Subscription) {
			return false;
		}

	}
}