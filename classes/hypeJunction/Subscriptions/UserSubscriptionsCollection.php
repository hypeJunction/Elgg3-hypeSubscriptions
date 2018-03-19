<?php

namespace hypeJunction\Subscriptions;

use hypeJunction\Lists\Collection;
use hypeJunction\Lists\SearchFields\Sort;
use hypeJunction\Lists\Sorters\TimeCreated;

class UserSubscriptionsCollection extends Collection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:object:subscription:owner';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		return elgg_echo('collection:object:subscription');
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
		return 'subscription';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollectionType() {
		return 'owner';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		$target = $this->getTarget();

		return array_merge([
			'types' => $this->getType(),
			'subtypes' => $this->getSubtypes(),
			'owner_guids' => (int) $target->guid,
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		$target = $this->getTarget();

		return elgg_generate_url($this->getId(), [
			'username' => $target->username,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListOptions(array $options = []) {
		return array_merge([
			'full_view' => false,
			'no_results' => elgg_echo('collection:object:subscription:owner:no_results'),
			'item_view' => 'subscriptions/subscription/user_view',
			'pagination_type' => 'infinite',
			'list_class' => 'subscriptions-subscribed-list',
			'list_type' => 'list',
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
			TimeCreated::id() => TimeCreated::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSearchOptions() {
		return [
			Sort::class,
			StatusSearchField::class,
		];
	}
}