<?php

namespace hypeJunction\Subscriptions;

use Elgg\Database\Clauses\WhereClause;
use Elgg\Database\QueryBuilder;
use hypeJunction\Lists\FilterInterface;

class StatusFilter implements FilterInterface {

	/**
	 * Returns ID of the filter
	 * @return string
	 */
	public static function id() {
		return 'status';
	}

	/**
	 * Build a filtering clause
	 *
	 * @param       $target \ElggEntity Target entity of the filtering relationship
	 * @param array $params Filter params
	 *
	 * @return WhereClause|null
	 */
	public static function build(\ElggEntity $target = null, array $params = []) {
		$status = elgg_extract('status', $params);

		if (!$status) {
			return null;
		}

		$filter = function (QueryBuilder $qb) use ($status) {
			switch ($status) {
				case 'active' :
					$qb->joinMetadataTable('e', 'guid', 'current_period_end', 'left', 'current_period_end');

					return $qb->merge([
						$qb->compare('current_period_end.value', '>', time(), ELGG_VALUE_TIMESTAMP),
						$qb->compare('current_period_end.value', 'IS NULL'),
					], 'OR');

				case 'cancelled' :
					$qb->joinMetadataTable('e', 'guid', 'current_period_end', 'inner', 'current_period_end');
					$qb->joinMetadataTable('e', 'guid', 'cancelled_at', 'left', 'cancelled_at');

					return $qb->merge([
						$qb->compare('current_period_end.value', '<', time(), ELGG_VALUE_TIMESTAMP),
						$qb->compare('cancelled_at.value', 'IS NOT NULL'),
					], 'OR');
			}
		};

		return new WhereClause($filter);
	}
}