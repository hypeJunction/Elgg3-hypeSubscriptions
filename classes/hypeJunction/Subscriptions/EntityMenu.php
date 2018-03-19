<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;
use ElggMenuItem;

class EntityMenu {

	/**
	 * Setup entity menu
	 *
	 * @elgg_plugin_hook register menu:entity
	 *
	 * @param Hook $hook Hook
	 *
	 * @return ElggMenuItem[]|null
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();

		if (!$entity instanceof Subscription) {
			return null;
		}

		$menu = $hook->getValue();
		/* @var $menu ElggMenuItem[] */

		$remove = ['delete'];

		foreach ($menu as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($menu[$key]);
			}
		}

		if (!$entity->cancelled_at && $entity->canEdit()) {
			$menu[] = ElggMenuItem::factory([
				'name' => 'cancel',
				'href' => elgg_generate_action_url('subscriptions/cancel', [
					'guid' => $entity->guid,
				]),
				'text' => elgg_echo('subscriptions:cancel'),
				'icon' => 'times',
				'confirm' => true,
			]);
		}

		return $menu;
	}
}