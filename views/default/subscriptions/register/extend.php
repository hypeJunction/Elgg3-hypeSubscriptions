<?php

if (!elgg_get_config('subscriptions.payment_on_registration')) {
	return;
}

$plans = elgg_get_config('subscriptions.registration_membership_plans');
if (empty($plans)) {
	return;
}

$plans = array_map(function ($guid) {
	return get_entity($guid);
}, $plans);

$intro = elgg_get_plugin_setting('registration_intro', 'hypeSubscriptions');
if ($intro) {
	$intro = elgg_view('output/longtext', [
		'value' => $intro,
	]);
	echo elgg_view_message('info', $message, [
		'title' => false,
	]);
}

echo elgg_view_field([
	'#type' => 'fieldset',
	'fields' => [
		[
			'#type' => 'subscriptions/plans',
			'#label' => elgg_echo('subscriptions:plans:select'),
			'plans' => $plans,
			'name' => 'plan_guid',
			'required' => true,
		],
		[
			'#type' => 'subscriptions/payment',
			'#label' => elgg_echo('subscriptions:plans:payment'),
			'required' => true,
		]
	],
]);