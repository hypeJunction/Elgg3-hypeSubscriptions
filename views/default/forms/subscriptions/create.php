<?php

$container = elgg_extract('container', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'container_guid',
	'value' => $container->guid,
]);

if (!$entity) {
	echo elgg_view_field([
		'#type' => 'userpicker',
		'#label' => elgg_echo('field:object:subscription:subscriber_guid'),
		'name' => 'subscriber_guids',
		'required' => true,
	]);
}

echo elgg_view_field([
	'#type' => 'date',
	'#label' => elgg_echo('field:object:subscription:expires_on'),
	'name' => 'current_period_end',
	'timestamp' => true,
	'datepicker_options' => [
		'minDate' => '+1d',
	],
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);

elgg_require_js('forms/subscriptions/create');