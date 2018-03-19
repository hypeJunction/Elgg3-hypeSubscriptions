<?php

$svc = elgg()->subscriptions;
/* @var $svc \hypeJunction\Subscriptions\SubscriptionsService */

$vars['gateways'] = $svc->getGateways();

echo elgg_view('input/payments/method', $vars);
