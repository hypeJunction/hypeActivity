<?php

namespace hypeJunction\Activity;

use Elgg\Hook;

class RiverFilterMenu {

	/**
	 * Setup river filter menu
	 *
	 * @elgg_plugin_hook register menu:river:filter
	 *
	 * @param Hook $hook Hook
	 *
	 * @return \ElggMenuItem[]
	 */
	public function __invoke(Hook $hook) {

		$menu = $hook->getValue();

		$svc = elgg()->activity;
		/* @var $svc \hypeJunction\Activity\Activity */

		$filters = $svc->getFilters();

		$parent_label = elgg_echo('activity:filter');

		foreach ($filters as $filter) {
			$query = $filter->query ? : [];
			$query['filter'] = $filter->id;

			$menu[] = \ElggMenuItem::factory([
				'name' => $filter->id,
				'parent_name' => 'filter',
				'text' => $filter->label,
				'href' => elgg_http_add_url_query_elements(current_page_url(), $query),
				'priority' => $filter->priority,
			]);

			if ($filter->id == get_input('filter')) {
				$parent_label = $filter->label;
			}
		}

		$menu[] = \ElggMenuItem::factory([
			'name' => 'filter',
			'href' => '#',
			'text' => $parent_label . elgg_view_icon('caret-down'),
			'child_menu' => [
				'display' => 'dropdown',
				'class' => 'elgg-river-filter-menu elgg-menu-hover elgg-module-popup',
				'data-position' => json_encode([
					'at' => 'left bottom',
					'my' => 'left top',
					'collision' => 'fit fit',
				]),
			],
		]);

		return $menu;
	}
}