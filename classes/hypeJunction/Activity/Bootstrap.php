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
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {
		elgg_unextend_view('groups/tool_latest', 'framework/wall/group_module');
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