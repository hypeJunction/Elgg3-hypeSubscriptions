<?php

namespace hypeJunction\Subscriptions;

use Elgg\Event;

class NotifySubscriptionCancel {

	/**
	 * Notify user when subscription is created
	 *
	 * @param Event $event Event
	 *
	 * @return void
	 * @throws \NotificationException
	 */
	public function __invoke(Event $event) {

		$entity = $event->getObject();
		if (!$entity instanceof Subscription) {
			return;
		}

		$subscriber = $entity->getOwnerEntity();

		$link = $entity->getDisplayName();
		$summary = elgg_echo('subscriptions:notify:cancel:subject', [$link]);
		$subject = strip_tags($summary);

		$message = elgg_echo('subscriptions:notify:cancel:message', [
			$entity->getDisplayName(),
			date('j M, Y', $entity->current_period_end),
			$entity->getURL(),
		]);

		notify_user($subscriber->guid, null, $subject, $message, [
			'summary' => $summary,
			'url' => elgg_generate_url('collection:object:subscription:owner', [
				'username' => $subscriber->username,
			]),
			'object' => $entity,
			'action' => 'paid_access',
		]);
	}
}