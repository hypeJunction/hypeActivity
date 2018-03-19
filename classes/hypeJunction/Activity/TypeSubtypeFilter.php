<?php

namespace hypeJunction\Activity;

use Elgg\Database\Clauses\WhereClause;
use Elgg\Database\QueryBuilder;
use hypeJunction\Lists\FilterInterface;

class TypeSubtypeFilter implements FilterInterface {

	/**
	 * {@inheritdoc}
	 */
	public static function build(\ElggEntity $target = null, array $params = []) {

		$type = elgg_extract('type', $params);
		$subtype = elgg_extract('subtype', $params);

		$filter = function (QueryBuilder $qb, $from_alias = 'rv') use ($type, $subtype) {
			$ands = [];

			if ($type) {
				$qb->joinEntitiesTable($from_alias, 'object_guid', 'inner', 'oe');
				$ands[] = $qb->compare('oe.type', '=', $type, ELGG_VALUE_STRING);

				if ($subtype) {
					$ands[] = $qb->compare('oe.subtype', '=', $subtype, ELGG_VALUE_STRING);
				}
			}

			return $qb->merge($ands, 'AND');
		};

		return new WhereClause($filter);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function id() {
		return 'object_type';
	}
}