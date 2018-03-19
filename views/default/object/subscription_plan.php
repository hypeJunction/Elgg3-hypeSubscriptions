<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \hypeJunction\Subscriptions\SubscriptionPlan) {
	return;
}

$params = array_merge($vars, [
	'icon' => false,
	'summary' => false,
	'attachments' => elgg_view('subscriptions/subscribers', $vars),
	'responses' => false,
	'byline' => false,
	'access' => false,
	'imprint' => [
		[
			'icon_name' => 'hashtag',
			'content' => $entity->plan_id,
		],
		[
			'icon_name' => 'calendar',
			'content' => elgg_echo('subscription:pricing:label', [
				$entity->getTotalPrice()->getConvertedAmount(),
				$entity->getTotalPrice()->getCurrency(),
				strtolower($entity->getCycle()->label),
			]),
		]
	],
]);

echo elgg_view('post/view', $params);
