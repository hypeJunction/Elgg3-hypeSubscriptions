<?php

namespace hypeJunction\Subscriptions;

use ElggEntity;
use hypeJunction\Fields\MetaField;
use hypeJunction\Payments\Amount;
use hypeJunction\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;

class PricingField extends MetaField {

	public function validate($value) {
		if (!$this->required) {
			return null;
		}

		if (!is_array($value) || empty($value) || empty($value['cycle']) || !isset($value['amount']) || empty($value['currency'])) {
			throw new ValidationException('Invalid pricing info');
		}

		parent::validate($value);
	}

	public function save(ElggEntity $entity, ParameterBag $parameters) {
		/* @var $entity \hypeJunction\Subscriptions\SubscriptionPlan */

		$name = $this->name;
		$value = $parameters->get($name);

		$cycle_name = elgg_extract('cycle', $value);

		$entity->setCycle($cycle_name);

		$price = elgg_extract('amount', $value, '0');
		$currency = elgg_extract('currency', $value);

		$amount = Amount::fromString($price, $currency);

		$entity->setPrice($amount);
	}

	public function retrieve(ElggEntity $entity) {
		/* @var $entity \hypeJunction\Subscriptions\SubscriptionPlan */

		$amount = $entity->getPrice();

		return [
			'cycle' => $entity->getCycle()->cycle,
			'amount' => $amount->getConvertedAmount(),
			'currency' => $amount->getCurrency(),
		];
	}

	public function isVisible(ElggEntity $entity, $context = null) {
		return !$entity->plan_id;
	}

}