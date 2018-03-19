<?php

$user = elgg_extract('user', $vars);
$plans = elgg_extract('plans', $vars);
if (empty($plans)) {
	return;
}

echo elgg_view_field([
	'#type' => 'subscriptions/plans',
	'#label' => elgg_echo('subscriptions:plan:select'),
	'plans' => $plans,
	'name' => 'plan_guid',
	'user' => $user,
	'required' => true,
]);

foreach ($plans as $plan) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'plan_options[]',
		'value' => $plan->guid,
	]);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'user_guid',
	'value' => $user->guid,
]);

echo elgg_view_field([
	'#type' => 'subscriptions/payment',
	'#label' => elgg_echo('subscriptions:payment:select'),
	'required' => true,
	'name' => 'payment_method',
	'intent' => 'subscription',
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('subscriptions:subscribe'),
	'icon' => 'lock',
]);

elgg_set_form_footer($footer);