<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;
use ElggMenuItem;

class PageMenu {

	/**
	 * Setup page menu
	 *
	 * @elgg_plugin_hook register menu:page
	 *
	 * @param Hook $hook Hook
	 *
	 * @return ElggMenuItem[]|null
	 */
	public function __invoke(Hook $hook) {

		$menu = $hook->getValue();
		/* @var $menu ElggMenuItem[] */

		if (elgg_in_context('settings')) {
			$page_owner = elgg_get_page_owner_entity();
			if ($page_owner instanceof \ElggUser) {
				$menu[] = ElggMenuItem::factory([
					'name' => 'subscriptions',
					'href' => elgg_generate_url('collection:object:subscription:owner', [
						'username' => $page_owner->username
					]),
					'text' => elgg_echo('collection:object:subscription'),
					'section' => 'subscriptions',
				]);

				$menu[] = ElggMenuItem::factory([
					'name' => 'subscriptions:site',
					'href' => elgg_generate_url('subscriptions:subscribe:site'),
					'text' => elgg_echo('subscriptions:subscribe:site'),
					'section' => 'subscriptions',
				]);
			}
		} else if (elgg_in_context('admin')) {
			$menu[] = ElggMenuItem::factory([
				'name' => 'subscriptions',
				'text' => elgg_echo('subscriptions'),
				'href' => false,
				'section' => 'configure',
			]);

			$menu[] = ElggMenuItem::factory([
				'name' => 'subscriptions:settings',
				'parent_name' => 'subscriptions',
				'href' => 'admin/plugin_settings/hypeSubscriptions',
				'text' => elgg_echo('settings'),
				'icon' => 'cog',
				'section' => 'configure',
			]);

			$menu[] = ElggMenuItem::factory([
				'name' => 'subscriptions:all',
				'parent_name' => 'subscriptions',
				'href' => elgg_generate_url('collection:object:subscription_plan:all'),
				'text' => elgg_echo('collection:object:subscription_plan'),
				'icon' => 'key',
				'section' => 'configure',
			]);
		}

		return $menu;
	}
}