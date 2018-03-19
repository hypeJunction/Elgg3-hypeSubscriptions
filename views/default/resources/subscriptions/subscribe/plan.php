<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', 'subscription_plan');

$entity = get_entity($guid);

$title = elgg_echo('subscriptions:subscribe');

elgg_push_collection_breadcrumbs('object', 'subcription_plan', $entity);
elgg_push_breadcrumb($title);

$content = elgg_view_form('subscriptions/subscribe', [], [
	'plans' => [$entity],
]);

if (elgg_is_xhr()) {
	echo elgg_view_module('aside', $title, $content);

	return;
}

$layout = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $layout);