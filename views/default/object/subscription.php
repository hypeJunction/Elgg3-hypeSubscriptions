<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Subscriptions\Subscription) {
	return;
}

$imprint = [];

$imprint[] = [
	'icon_name' => 'key',
	'content' => $entity->getContainerEntity()->getDisplayName(),
];

if ($entity->current_period_end) {
	$date = elgg_view('output/date', [
		'value' => $entity->current_period_end,
	]);

	if ($entity->cancelled_at) {
		$label = elgg_echo('subscription:cancel_at_period_end', [$date]);
	} else {
		if ($entity->current_period_end > time()) {
			$label = elgg_echo('subscription:current_period_end', [$date]);
		} else {
			$label = elgg_echo('subscription:ended', [$date]);
		}
	}


	$imprint[] = [
		'icon_name' => 'clock-o',
		'content' => $label,
	];
}

echo elgg_view('object/elements/summary', array_merge($vars, [
	'imprint' => $imprint,
	'byline' => false,
	'access' => false,
	'time' => false,
	'icon' => elgg_view_entity_icon($entity, 'small'),
]));