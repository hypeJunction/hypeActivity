<?php

namespace hypeJunction\Activity;

use hypeJunction\Lists\FilterInterface;

class Activity {

	/**
	 * Get a filter by its id
	 *
	 * @param string $id Filter name
	 *
	 * @return \stdClass|null
	 */
	public function getFilter($id) {
		$filters = $this->getFilters();

		foreach ($filters as $filter) {
			if ($filter->id == $id) {
				return $filter;
			}
		}
	}

	/**
	 * Returns all registered filters
	 * @return array
	 */
	public function getFilters() {

		$filters = [
			(object) [
				'id' => 'all',
				'label' => elgg_echo('all'),
				'handler' => TypeSubtypeFilter::class,
				'query' => [
					'filter' => TypeSubtypeFilter::id(),
					'type' => '',
					'subtype' => '',
				],
			],
		];

		$types = get_registered_entity_types();
		foreach ($types as $type => $subtypes) {
			if (empty($subtypes)) {
				$filters[] = (object) [
					'id' => $type,
					'label' => elgg_echo("collection:$type"),
					'handler' => TypeSubtypeFilter::class,
					'query' => [
						'filter' => TypeSubtypeFilter::id(),
						'type' => $type,
						'subtype' => '',
					],
				];
			} else {
				foreach ($subtypes as $subtype) {
					$filters[] = (object) [
						'id' => "$type:$subtype",
						'label' => elgg_echo("collection:$type:$subtype"),
						'handler' => TypeSubtypeFilter::class,
						'query' => [
							'filter' => TypeSubtypeFilter::id(),
							'type' => $type,
							'subtype' => $subtype,
						],
					];
				}
			}
		}

		$filters = elgg_trigger_plugin_hook('filters', 'feed', null, $filters);

		$filters = array_filter($filters, function ($filter) {
			return $filter->id && $filter->label && is_subclass_of($filter->handler, FilterInterface::class);
		});

		return $filters;
	}
}