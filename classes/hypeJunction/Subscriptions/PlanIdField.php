<?php

namespace hypeJunction\Subscriptions;

use ElggEntity;
use hypeJunction\Fields\MetaField;
use Symfony\Component\HttpFoundation\ParameterBag;

class PlanIdField extends MetaField {

	public function save(ElggEntity $entity, ParameterBag $parameters) {
		/* @var $entity \hypeJunction\Subscriptions\SubscriptionPlan */

		$name = $this->name;
		$value = $parameters->get($name);

		$entity->setPlanId($value);
	}

	public function isVisible(ElggEntity $entity, $context = null) {
		return !$entity->plan_id;
	}
}