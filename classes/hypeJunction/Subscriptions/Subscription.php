<?php

namespace hypeJunction\Subscriptions;

/**
 * Subscription
 *
 * @property int $current_period_end
 * @property int $cancelled_at
 */
class Subscription extends \ElggObject {

	const SUBTYPE = 'subscription';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		$owner = $this->getOwnerEntity();
		if (!$owner) {
			return false;
		}

		if ($owner->canEdit()) {
			return elgg_generate_url('collection:object:subscription:owner', [
				'username' => $this->getOwnerEntity()->username,
			]);
		}

		return $owner->getURL();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIconURL($params = []) {
		$owner = $this->getOwnerEntity();
		if ($owner) {
			return $owner->getIconURL($params);
		}

		return parent::getIconURL($params);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		$owner = $this->getOwnerEntity();
		if ($owner) {
			return $owner->getDisplayName();
		}

		return parent::getDisplayName();
	}

	/**
	 * Cancel subscription
	 *
	 * @param bool $at_period_end Cancel at period end
	 *                            If not set, will use setting value
	 *
	 * @return bool
	 */
	public function cancel($at_period_end = null) {
		if ($this->cancelled_at) {
			return false;
		}

		if (elgg_trigger_before_event('cancel', 'subscription', $this)) {

			$this->cancelled_at = time();

			if (!isset($at_period_end)) {
				$at_period_end = elgg_get_config('subscriptions.cancellation_type') == 'at_period_end';
			}

			if (!$at_period_end) {
				$this->current_period_end = time();
			}

			elgg_trigger_event('cancel', 'subscription', $this);

			elgg_trigger_after_event('cancel', 'subscription', $this);

			return true;
		}

		return false;
	}
}
