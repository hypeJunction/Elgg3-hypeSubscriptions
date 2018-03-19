<?php

$plans = elgg_extract('plans', $vars);
$user = elgg_extract('user', $vars);

if (empty($plans)) {
	return;
}

$name = elgg_extract('name', $vars);

$svc = elgg()->subscriptions;
/* @var $svc \hypeJunction\Subscriptions\SubscriptionsService */

$value = elgg_extract('value', $vars);

if (!$value) {
	$value = [];

	foreach ($plans as $plan) {
		if ($svc->hasPlan($plan, $user)) {
			$value[] = $plan->guid;
		}
	}
}

if (empty($value)) {
    // select first plan
    $value[] = $plans[0]->guid;
}

?>

<div class="subscriptions-plan-selector">
	<?php
	foreach ($plans as $plan) {
		if (!$plan instanceof \hypeJunction\Subscriptions\SubscriptionPlan) {
			continue;
		}
		$pricing = elgg_echo('subscription:pricing:label', [
			$plan->getTotalPrice()->getConvertedAmount(),
			$plan->getTotalPrice()->getCurrency(),
			strtolower($plan->getCycle()->label),
		]);
		?>
        <div>
			<?php
			echo elgg_format_element('input', [
				'type' => 'radio',
				'name' => $name,
				'value' => $plan->guid,
				'id' => $plan->guid,
				'checked' => in_array($plan->guid, $value),
				'class' => 'subscriptions-plan-selector-input',
			])
			?>
            <label for="<?= $plan->guid ?>" class="subscriptions-plan-selector-label">
                <div class="elgg-image-block">
                    <div class="elgg-image">
                        <div class="subscriptions-plan-selector-checkbox">
							<?= elgg_view_icon('check') ?>
                        </div>
                    </div>
                    <div class="elgg-body">
                        <h3><?= $plan->getDisplayName() ?>
                            <small><?= $pricing ?></small>
                        </h3>
						<?php
						echo elgg_view('output/longtext', [
							'value' => $plan->description,
							'class' => 'elgg-subtext',
						]);
						?>
                    </div>
                </div>
            </label>
        </div>
		<?php
	}
	?>
</div>
