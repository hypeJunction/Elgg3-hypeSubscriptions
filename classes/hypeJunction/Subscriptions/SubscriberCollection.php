<?php

namespace hypeJunction\Subscriptions;

use hypeJunction\Lists\Collection;
use hypeJunction\Lists\Sorters\TimeCreated;

class SubscriberCollection extends Collection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:object:subscription:all';
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
		return 'all';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		$target = $this->getTarget();

		return array_merge([
			'types' => $this->getType(),
			'subtypes' => $this->getSubtypes(),
			'container_guids' => (int) $target->guid,
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		$target = $this->getTarget();

		return elgg_generate_url($this->getId(), [
			'guid' => (int) $target->guid,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListOptions(array $options = []) {
		return array_merge([
			'full_view' => false,
			'no_results' => elgg_echo('collection:object:subscription:no_results'),
			'pagination_type' => 'infinite',
			'list_class' => 'subscriptions-subscribers-list',
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
		return [];
	}
}