<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

$title = elgg_echo('add:object:subscription');

elgg_push_collection_breadcrumbs('object', 'subcription', $entity);
elgg_push_breadcrumb($title);

$content = elgg_view_form('subscriptions/create', [], [
	'container' => $entity,
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