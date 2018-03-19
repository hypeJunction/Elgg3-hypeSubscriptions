<?php

namespace hypeJunction\Subscriptions;

use hypeJunction\Lists\Collection;
use hypeJunction\Lists\Filters\All;
use hypeJunction\Lists\Filters\IsContainedByUsersGroups;
use hypeJunction\Lists\Filters\IsOwnedBy;
use hypeJunction\Lists\Filters\IsOwnedByFriendsOf;
use hypeJunction\Lists\SearchFields\CreatedBetween;
use hypeJunction\Lists\Sorters\Alpha;
use hypeJunction\Lists\Sorters\LastAction;
use hypeJunction\Lists\Sorters\LikesCount;
use hypeJunction\Lists\Sorters\ResponsesCount;
use hypeJunction\Lists\Sorters\TimeCreated;

class PlanCollection extends Collection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:object:subscription_plan:all';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		return elgg_echo('collection:object:subscription_plan');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType() {
		return 'object';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubtypes() {
		return 'subscription_plan';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollectionType() {
		return 'all';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		return array_merge([
			'types' => $this->getType(),
			'subtypes' => $this->getSubtypes(),
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		return elgg_generate_url($this->getId());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListOptions(array $options = []) {
		return array_merge([
			'full_view' => false,
			'no_results' => elgg_echo('collection:object:subscription_plan:no_results'),
			'pagination_type' => 'infinite',
			'list_class' => 'subscriptions-plans-list',
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilterOptions() {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSortOptions() {
		return [
			Alpha::id() => Alpha::class,
			TimeCreated::id() => TimeCreated::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMenu() {

		$menu = [];

		$site = elgg_get_site_entity();
		if ($site->canWriteToContainer(0, 'object', 'subscription_plan')) {
			$menu[] = \ElggMenuItem::factory([
				'name' => 'add',
				'href' => elgg_generate_url('add:object:subscription_plan', [
					'guid' => $site->guid,
				]),
				'text' => elgg_echo('add:object:subscription_plan'),
				'icon' => 'plus',
			]);
		}

		return $menu;
	}
}