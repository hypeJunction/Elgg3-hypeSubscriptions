<?php

$entity = elgg_extract('entity', $vars);

$fields = [
	'subscriptions.site_paywall' => [
		'#type' => 'select',
		'options_values' => [
			0 => elgg_echo('option:no'),
			1 => elgg_echo('option:yes'),
		],
	],
	'subscriptions.site_membership_plans' => [
		'#type' => 'guids',
		'options' => [
			'type' => 'object',
			'subtype' => \hypeJunction\Subscriptions\SubscriptionPlan::SUBTYPE,
		],
	],
	'subscriptions.payment_on_registration' => [
		'#type' => 'select',
		'options_values' => [
			0 => elgg_echo('option:no'),
			1 => elgg_echo('option:yes'),
		],
	],
	'subscriptions.registration_membership_plans' => [
		'#type' => 'guids',
		'options' => [
			'type' => 'object',
			'subtype' => \hypeJunction\Subscriptions\SubscriptionPlan::SUBTYPE,
		],
	],
	'subscriptions.cancellation_type' => [
		'#type' => 'select',
		'options_values' => [
			'instant' => elgg_echo('subscriptions:cancellation:instant'),
			'at_period_end' => elgg_echo('subscriptions:cancellation:at_period_end'),
		]
	],
	'registration_intro' => [
		'#type' => 'longtext',
		'name' => 'params[registration_intro]',
		'value' => $entity->registration_intro,
	],
];

foreach ($fields as $name => $options) {
	if (is_string($options)) {
		$options = [
			'#type' => $options,
		];
	}

	if (!isset($options['name'])) {
		$options['name'] = "config[$name]";
	}

	if (!isset($options['value'])) {
		$options['value'] = elgg_get_config($name);
	}

	$options['#label'] = elgg_echo("subscriptions:setting:$name");
	if (elgg_language_key_exists("subscriptions:setting:$name:help")) {
		$options['#help'] = elgg_echo("subscriptions:setting:$name:help");
	}

	echo elgg_view_field($options);
}