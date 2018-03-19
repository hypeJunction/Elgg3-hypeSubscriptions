<?php

namespace hypeJunction\Subscriptions;

use hypeJunction\Lists\SearchFields\SearchField;

class StatusSearchField extends SearchField {

	/**
	 * Returns field name
	 * @return string
	 */
	public function getName() {
		return 'status';
	}

	/**
	 * Returns field parameters
	 * @return array|null
	 */
	public function getField() {
		return [
			'#type' => 'select',
			'#label' => elgg_echo('subscriptions:status'),
			'name' => $this->getName(),
			'value' => $this->getValue(),
			'options_values' => [
				'' => '',
				'active' => elgg_echo('subscriptions:status:active'),
				'cancelled' => elgg_echo('subscriptions:status:cancelled'),
			],
		];
	}

	/**
	 * Set constraints on the collection based on field value
	 * @return void
	 */
	public function setConstraints() {
		$value = $this->getValue();
		if (!$value) {
			return;
		}

		$this->collection->addFilter(StatusFilter::class, null, ['status' => $value]);
	}
}