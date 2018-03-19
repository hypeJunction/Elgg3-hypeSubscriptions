<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Subscriptions\SubscriptionPlan) {
	return;
}

$collection = elgg_get_collection('collection:object:subscription:all', $entity);

$view = $collection->render($vars);

if (!$view) {
	return;
}

if ($entity->canEdit()) {
	$menu = elgg_view('output/url', [
		'href' => elgg_generate_url('add:object:subscription', [
			'guid' => $entity->guid,
		]),
		'text' => elgg_echo('add:object:subscription'),
		'icon' => 'plus',
		'class' => 'elgg-lightbox',
		'data-colorbox-opts' => json_encode([
			'width' => '800px',
		]),
	]);
}

echo elgg_view_module('aside', $collection->getDisplayName(), $view, [
	'menu' => $menu,
]);