<?php

namespace hypeJunction\Activity;

use Elgg\HooksRegistrationService\Hook;

class SetupGroupModules {

	public function __invoke(Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}

		$modules = $hook->getValue();

		if (elgg_is_active_plugin('hypeGroups')) {
			$modules['admins'] = [
				'position' => 'sidebar',
				'priority' => 100,
				'label' => elgg_echo('groups:admins'),
				'view' => 'groups/sidebar/admins',
			];
		}

		$modules['members'] = [
			'position' => 'sidebar',
			'priority' => 150,
			'label' => elgg_echo('groups:members'),
			'view' => 'groups/sidebar/members',
		];

		$modules['search'] = [
			'position' => 'sidebar',
			'priority' => 950,
			'label' => elgg_echo('groups:search'),
			'view' => 'groups/sidebar/search',
		];

		$tools = elgg()->group_tools->group($entity)->sort();

		foreach ($tools as $tool) {
			if (elgg_view_exists("groups/profile/module/{$tool->name}")) {
				$modules["tool:$tool->name"] = [
					'position' => 'sidebar',
					'priority' => 500,
					'label' => $tool->label,
					'view' => "groups/profile/module/{$tool->name}",
				];
			}
		}

		return $modules;
	}
}