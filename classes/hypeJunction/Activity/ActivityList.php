<?php

namespace hypeJunction\Activity;

use Elgg\Database\Clauses\WhereClause;
use Elgg\Database\QueryBuilder;
use ElggEntity;
use hypeJunction\Lists\FilterInterface;
use PHPUnit\Util\Filter;

class ActivityList extends \Elgg\Database\River {

	/**
	 * {@inheritdoc}
	 */
	public function addSort($field, $direction = null, $as = null) {
		/* @todo Implement sorting */

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setSearchQuery($query = '') {

		$fields = [
			'attributes' => [],
			'metadata' => [
				'name',
				'title',
				'description',
			],
			'annotations' => [],
			'private_settings' => [],
		];

		$options = $this->options->getArrayCopy();

		$types = $this->options->type_subtype_pairs;
		if (sizeof($types) === 1) {
			$type = array_shift(array_keys($types));
			$fields = elgg_trigger_plugin_hook('search:fields', $type, $options, $fields);
		}

		$query = filter_var($query, FILTER_SANITIZE_STRING);
		$query = trim($query);

		$words = preg_split('/\s+/', $query);
		$words = array_map(function ($e) {
			return trim($e);
		}, $words);

		$query_parts = array_unique(array_filter($words));

		$query = function (QueryBuilder $qb, $alias) use ($fields, $query_parts) {
			$oe = $qb->joinEntitiesTable($alias, 'object_guid');
			return _elgg_services()->search->buildSearchWhereQuery($qb, $oe, $fields, $query_parts);
		};

		$this->options->where(new WhereClause($query));

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addFilter($class, ElggEntity $target = null, array $params = []) {
		if (!is_subclass_of($class, FilterInterface::class)) {
			throw new \InvalidParameterException($class . ' must implement ' . FilterInterface::class);
		}

		/* @var $class FilterInterface */

		$where = $class::build($target, $params);

		if ($where) {
			$this->options->where($where);
		}

		return $this;
	}

	/**
	 * Get options
	 * @return \Elgg\Database\QueryOptions
	 */
	public function getOptions() {
		return $this->options;
	}
}
