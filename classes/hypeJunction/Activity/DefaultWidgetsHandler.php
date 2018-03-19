<?php

namespace hypeJunction\Activity;

use Elgg\Hook;

class DefaultWidgetsHandler {

	/**
	 * Add dashboard context to default widgets interface
	 *
	 * @param Hook $hook Hook
	 *
	 * @return array
	 */
	public function __invoke(Hook $hook) {

		$return[] = [
			'name' => elgg_echo('activity:widgets:dashboard'),
			'widget_context' => 'dashboard',
			'widget_columns' => 1,

			'event' => 'create',
			'entity_type' => 'user',
			'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
		];

		$return[] = [
			'name' => elgg_echo('activity:widgets:profile'),
			'widget_context' => 'profile',
			'widget_columns' => 1,

			'event' => 'create',
			'entity_type' => 'user',
			'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
		];

		$return[] = [
			'name' => elgg_echo('activity:widgets:group_profile'),
			'widget_context' => 'group_profile',
			'widget_columns' => 1,

			'event' => 'create',
			'entity_type' => 'user',
			'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
		];

		return $return;
	}
}