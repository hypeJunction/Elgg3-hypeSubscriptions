<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;
use Elgg\Request;
use hypeJunction\Fields\Collection;
use hypeJunction\Fields\HtmlField;
use hypeJunction\Fields\MetaField;
use hypeJunction\Fields\TitleField;
use hypeJunction\Payments\Amount;

class SubscriptionPlanFields {

	/**
	 * Setup subscription plan form
	 *
	 * @param Hook $hook Hook
	 * @return Collection
	 */
	public function __invoke(Hook $hook) {

		$fields = new Collection();

		$fields->add('plan_id', new PlanIdField([
			'type' => 'text',
			'section' => 'content',
			'is_export_field' => true,
			'required' => true,
		]));

		$fields->add('title', new TitleField([
			'type' => 'text',
			'is_profile_field' => false,
			'required' => true,
			'is_export_field' => true,
		]));

		$fields->add('internal_use', new MetaField([
			'type' => 'checkbox',
			'is_profile_field' => false,
			'is_export_field' => true,
		]));

		$fields->add('pricing', new PricingField([
			'type' => 'subscriptions/pricing',
			'required' => true,
			'section' => 'content',
			'is_export_field' => false,
		]));

		$fields->add('trial_period_days', new MetaField([
			'type' => 'number',
			'section' => 'content',
		]));

		$fields->add('description', new HtmlField([
			'type' => 'longtext',
			'rows' => 3,
			'section' => 'content',
			'is_profile_field' => false,
			'is_export_field' => true,
		]));

		$fields->add('access_id', new MetaField([
			'type' => 'hidden',
			'value' => ACCESS_PUBLIC,
		]));

		return $fields;
	}
}