<?php

namespace hypeJunction\Activity;

use Elgg\Includer;
use Elgg\PluginBootstrap;

class Bootstrap extends PluginBootstrap {

	/**
	 * Get plugin root
	 * @return string
	 */
	protected function getRoot() {
		return $this->plugin->getPath();
	}

	/**
	 * {@inheritdoc}
	 */
	public function load() {
		Includer::requireFileOnce($this->getRoot() . '/autoloader.php');
	}

	/**
	 * {@inheritdoc}
	 */
	public function boot() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		elgg_extend_view('elgg.css', 'activity.css');

		elgg_register_plugin_hook_handler('register', 'menu:site', SiteMenu::class);
		elgg_register_plugin_hook_handler('register', 'menu:river:filter', RiverFilterMenu::class);

		elgg_register_plugin_hook_handler('get_list', 'default_widgets', DefaultWidgetsHandler::class);

		elgg_register_collection('collection:river:all', DefaultActivityCollection::class);
		elgg_register_collection('collection:river:owner', OwnedActivivityCollection::class);
		elgg_register_collection('collection:river:friends', FriendsActivityCollection::class);
		elgg_register_collection('collection:river:group', GroupActivityCollection::class);

		elgg_unextend_view('groups/sidebar/members', 'groups/sidebar/admins');

		elgg_register_plugin_hook_handler('modules', 'group', SetupGroupModules::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function shutdown() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function activate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function deactivate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function upgrade() {

	}

}