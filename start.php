<?php

require_once __DIR__ . '/autoloader.php';

return function () {

	elgg_register_event_handler('init', 'system', function () {

		elgg_extend_view('elgg.css', 'activity.css');
		
		elgg_register_menu_item('site', [
			'name' => 'activity',
			'text' => elgg_echo('activity'),
			'href' => elgg_generate_url('default:river'),
		]);

		elgg_register_plugin_hook_handler('register', 'menu:river:filter', \hypeJunction\Activity\RiverFilterMenu::class);

		elgg_register_plugin_hook_handler('get_list', 'default_widgets', \hypeJunction\Activity\DefaultWidgetsHandler::class);

		elgg_register_collection('collection:river:all', \hypeJunction\Activity\DefaultActivityCollection::class);
		elgg_register_collection('collection:river:owner', \hypeJunction\Activity\OwnedActivivityCollection::class);
		elgg_register_collection('collection:river:friends', \hypeJunction\Activity\FriendsActivityCollection::class);
		elgg_register_collection('collection:river:group', \hypeJunction\Activity\GroupActivityCollection::class);

		elgg_unextend_view('groups/tool_latest', 'framework/wall/group_module');
	});
};
