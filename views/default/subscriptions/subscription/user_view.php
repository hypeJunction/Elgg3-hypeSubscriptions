<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Subscriptions\Subscription) {
	return;
}

$plan = $entity->getContainerEntity();
if (!$plan instanceof \hypeJunction\Subscriptions\SubscriptionPlan) {
	return;
}

$imprint = [];

$imprint[] = [
	'icon_name' => 'calendar',
	'content' => elgg_echo('subscription:pricing:label', [
		$plan->getTotalPrice()->getConvertedAmount(),
		$plan->getTotalPrice()->getCurrency(),
		strtolower($plan->getCycle()->label),
	]),
];

$message_type = 'success';

if ($entity->current_period_end) {
	$date = elgg_view('output/date', [
		'value' => $entity->current_period_end,
	]);

	if ($entity->cancelled_at) {
		if ($entity->current_period_end > time()) {
			$label = elgg_echo('subscription:cancel_at_period_end', [$date]);
			$message_type = 'warning';
		} else {
			$label = elgg_echo('subscription:ended', [$date]);
			$message_type = 'error';
		}
	} else {
		$label = elgg_echo('subscription:current_period_end', [$date]);
		$message_type = 'success';
	}

	$imprint[] = [
		'icon_name' => 'clock-o',
		'content' => $label,
	];
}

$summary = elgg_view('object/elements/summary', array_merge($vars, [
	'imprint' => $imprint,
	'byline' => false,
	'access' => false,
	'time' => false,
	'title' => $plan->getDisplayName(),
	'icon' => false,
]));

echo elgg_view_message($message_type, $summary, [
	'title' => false,
]);