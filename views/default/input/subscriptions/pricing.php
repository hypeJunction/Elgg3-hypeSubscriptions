<?php

$value = (array) elgg_extract('value', $vars, []);
$name = elgg_extract('name', $vars, 'pricing');

$config = elgg()->{'subscriptions.config'};
/* @var $config \hypeJunction\Subscriptions\Config */

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'select',
			'#label' => elgg_echo('field:subscription:cycle'),
			'name' => "{$name}[cycle]",
			'value' => elgg_extract('cycle', $value),
			'options_values' => array_map(function($e) {
				return $e->label;
			}, $config->getCycles()),
		],
		[
			'#type' => 'payments/amount',
			'#label' => elgg_echo('field:subscription:price'),
			'name' => $name,
			'value' => $value,
		],
	],
]);