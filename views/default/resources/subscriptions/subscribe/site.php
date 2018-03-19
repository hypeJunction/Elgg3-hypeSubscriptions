<?php

$user = elgg_get_logged_in_user_entity();
if (!$user) {
	forward(elgg_get_registration_url());
}

$plans = elgg_get_config('subscriptions.registration_membership_plans');
if (empty($plans)) {
	throw new \Elgg\PageNotFoundException();
}

elgg_set_page_owner_guid($user->guid);

$title = elgg_echo('subscriptions:subscribe:site');

$content = elgg_view_form('subscriptions/subscribe', [], [
	'plans' => array_map(function ($guid) {
		return get_entity($guid);
	}, $plans),
	'user' => $user,
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