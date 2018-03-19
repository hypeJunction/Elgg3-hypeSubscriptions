<?php

return [
	'subscriptions' => 'Subscriptions',

	'item:object:subscription_plan' => 'Subscription Plan',
	'collection:object:subscription_plan' => 'Subscription Plans',
	'add:object:subscription_plan' => 'Create Plan',
	'edit:object:subscription_plan' => 'Edit Plan',

	'item:object:subscription' => 'Subscription',
	'collection:object:subscription' => 'Subscriptions',
	'add:object:subscription' => 'Add Subscriber',
	'edit:object:subscription' => 'Edit Subscription',

	'field:object:subscription_plan:plan_id' => 'Plan ID',
	'field:object:subscription_plan:plan_id:help' => 'Plan id must be unique, can only contain lowercase letters and underscores',
	'field:object:subscription_plan:title' => 'Plan Name',
	'field:object:subscription_plan:description' => 'Plan Description',
	'field:object:subscription_plan:pricing' => 'Pricing',
	'field:object:subscription_plan:trial_period_days' => 'Trial Period',
	'field:object:subscription_plan:trial_period_days:help' => 'Number of days before first payment is charged',

	'field:object:subscription:subscriber_guid' => 'Subscriber',
	'field:object:subscription:current_period_end' => 'Renews on',
	'field:object:subscription:expires_on' => 'Expires on',
	'field:object:subscription:current_period_end:help' => 'If set to expire, the subscription will be cancelled on this date',

	'field:subscription:cycle' => 'Billing Cycle',
	'field:subscription:price' => 'Price',
	'field:subscription:currency' => 'Currency',

	'subscription:cycle:daily' => 'Daily',
	'subscription:cycle:weekly' => 'Weekly',
	'subscription:cycle:biweekly' => 'Biweekly',
	'subscription:cycle:monthly' => 'Monthly',
	'subscription:cycle:bimonthly' => 'Bimonthly',
	'subscription:cycle:quarterly' => 'Quarterly',
	'subscription:cycle:yearly' => 'Yearly',

	'collection:object:subscription_plan:no_results' => 'No subscription plans have been created yet',
	'collection:object:subscription:no_results' => 'This plan has no subscribers yet',
	'collection:object:subscription:owner:no_results' => 'There are no subscriptions to display',

	'subscription:current_period_end' => 'Renews on %s',
	'subscription:ended' => 'Ended on %s',
	'subscription:cancel_at_period_end' => 'Ends on %s',

	'subscriptions:cancel' => 'Cancel',
	'subscriptions:cancel:success' => 'Subscription has been cancelled',
	'subscriptions:cancel:error' => 'Subscription could not be cancelled',

	'subscriptions:create:success' => 'Subscriptions have been updated',

	'subscription:pricing:label' => '%s %s %s',

	'subscriptions:subscribe' => 'Subscribe',
	'subscriptions:subscribe:site' => 'Manage site subscription',
	'subscription:payment_methods:no_results' => 'No payments methods have been configured',

	'subscriptions:setting:subscriptions.site_paywall' => 'Enable paywall',
	'subscriptions:setting:subscriptions.site_paywall:help' => 'If enabled, all users will be required to have an active subscription to navigate the site',

	'subscriptions:setting:subscriptions.site_membership_plans' => 'Site plans',
	'subscriptions:setting:subscriptions.site_membership_plans:help' => 'If paywall is enabled, users will need to have one of these plans to access the site',

	'subscriptions:setting:subscriptions.payment_on_registration' => 'Payment on registration',
	'subscriptions:setting:subscriptions.payment_on_registration:help' => 'If enabled, users will be required to pick a plan and provide payment details on registration',

	'subscriptions:setting:subscriptions.registration_membership_plans' => 'Registration plans',
	'subscriptions:setting:subscriptions.registration_membership_plans:help' => 'If payment on registration is enabled, these plans will be available on the registration page',

	'subscriptions:setting:subscriptions.cancellation_type' => 'Cancellation type',
	'subscriptions:setting:subscriptions.cancellation_type:help' => 'If set to Instant, cancellations will be cancelled and access terminated immediately, otherwise the subscriptions will be cancelled, but will remain active until period end',

	'subscriptions:setting:registration_intro' => 'Registration text',
	'subscriptions:setting:registration_intro:help' => 'Text to display on the registration form',

	'subscriptions:cancellation:instant' => 'Instant',
	'subscriptions:cancellation:at_period_end' => 'At period end',

	'SitePaywallException' => 'Access to this page is restricted to users with an active subscription',

	'subscriptions:subscribe:success' => 'You have been subscribed to the %s plan',
	'subscriptions:subscribe:error' => 'There was a problem creating a new subscription',
	'subscriptions:subscribe:cancel:success' => 'Your subscription to the %s plan has been cancelled',

	'subscriptions:status' => 'Status',
	'subscriptions:status:active' => 'Active',
	'subscriptions:status:cancelled' => 'Cancelled',

	'subscriptions:plans:select' => 'Membership plan',
	'subscriptions:plans:payment' => 'Payment details',

	'subscriptions:plan:select' => 'Select a plan',
	'subscriptions:payment:select' => 'Pay with',

	'subscriptions:error:payment_required' => 'Please provide valid card details to start the subscription',
	'subscriptions:error:invalid_plan' => 'Select plan is not valid',

	'subscriptions:notify:start:subject' => 'Subscription to %s plan is now active',
	'subscriptions:notify:start:message' => '
		Subscription to %s plan has been activated.
		
		If you have a payment source on record, the subscription will auto-renew on %s.
		
		You can manage your subscriptions here:
		%s
	',

	'subscriptions:notify:cancel:subject' => 'Subscription to %s plan has been cancelled',
	'subscriptions:notify:cancel:message' => '
		Subscription to %s plan has been cancelled.
		
		Subscription will become invalid on %s and no further charges will be made.
		
		You can manage your subscriptions here:
		%s
	',
];