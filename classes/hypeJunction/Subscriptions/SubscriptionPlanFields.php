<?php

namespace hypeJunction\Subscriptions;

use Elgg\Hook;
use Elgg\Request;
use hypeJunction\Payments\Amount;

class SubscriptionPlanFields {

	/**
	 * Setup subscription plan form
	 *
	 * @param Hook $hook Hook
	 * @return array
	 */
	public function __invoke(Hook $hook) {

		$fields = [];

		$fields['plan_id'] = [
			'#type' => 'text',
			'#section' => 'content',
			'#setter' => function(\ElggEntity $entity, $value) {
				/* @var $entity SubscriptionPlan */
				$entity->setPlanId($value);
			},
			'#profile' => false,
			'#visibility' => function(\ElggEntity $entity) {
				return !$entity->plan_id;
			},
			'required' => true,
		];

		$fields['title'] = [
			'#type' => 'text',
			'#section' => 'content',
			'#input' => function (Request $request) {
				return elgg_get_title_input();
			},
			'#profile' => false,
			'required' => true,
		];

		$config = elgg()->{'subscriptions.config'};
		/* @var $config \hypeJunction\Subscriptions\Config */

		$fields['pricing'] = [
			'#type' => 'subscriptions/pricing',
			'required' => true,
			'#validate' => function($value, $params) {
				$required = elgg_extract('required', $params);
				if (!$required) {
					return null;
				}

				if (empty($value['cycle']) || empty($value['amount'] || empty($value['currency']))) {
					return false;
				}
			},
			'#setter' => function(\ElggEntity $entity, $value) use ($config) {
				/* @var $entity \hypeJunction\Subscriptions\SubscriptionPlan */

				$cycle_name = elgg_extract('cycle', $value);

				$entity->setCycle($cycle_name);

				$price = elgg_extract('amount', $value, '0');
				$currency = elgg_extract('currency', $value);

				$amount = Amount::fromString($price, $currency);

				$entity->setPrice($amount);
			},
			'#getter' => function(\ElggEntity $entity) use ($config) {
				/* @var $entity \hypeJunction\Subscriptions\SubscriptionPlan */

				$amount = $entity->getPrice();

				return [
					'cycle' => $entity->getCycle()->cycle,
					'amount' => $amount->getConvertedAmount(),
					'currency' => $amount->getCurrency(),
				];
			},
			'#visibility' => function(\ElggEntity $entity) {
				return !$entity->plan_id;
			},
			'#section' => 'content',
		];

		$fields['trial_period_days'] = [
			'#type' => 'number',
			'#section' => 'content',
		];

		$fields['description'] = [
			'#type' => 'longtext',
			'rows' => 3,
			'#section' => 'content',
			'#profile' => false,
		];

		$fields['access_id'] = [
			'#type' => 'hidden',
			'value' => ACCESS_PUBLIC,
		];

		return $fields;
	}
}