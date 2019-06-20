<?php

namespace hypeJunction\Activity;

use Elgg\HooksRegistrationService\Hook;

class SiteMenu {

	public function __invoke(Hook $hook) {
		$menu = $hook->getValue();

		$gatekeeper = (bool) elgg_get_plugin_setting('gatekeeper', 'hypeActivity');

		if (!$gatekeeper || elgg_is_logged_in()) {
			$menu->add(\ElggMenuItem::factory([
				'name' => 'activity',
				'text' => elgg_echo('activity'),
				'href' => elgg_generate_url('default:river'),
			]));
		}

		return $menu;
	}
}