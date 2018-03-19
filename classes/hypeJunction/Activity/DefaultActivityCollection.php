<?php

namespace hypeJunction\Activity;

class DefaultActivityCollection extends Collection {

	/**
	 * Get ID of the collection
	 * @return string
	 */
	public function getId() {
		return 'collection:river:all';
	}

	/**
	 * Get title of the collection
	 * @return string
	 */
	public function getDisplayName() {
		return elgg_echo('collection:river');
	}

	/**
	 * Get the type of collection, e.g. owner, friends, group all
	 * @return string
	 */
	public function getCollectionType() {
		return 'all';
	}

	/**
	 * Get type of entities in the collection
	 * @return mixed
	 */
	public function getType() {
		return 'river';
	}

	/**
	 * Get subtypes of entities in the collection
	 * @return string|string[]
	 */
	public function getSubtypes() {
		return null;
	}

	/**
	 * Get default query options
	 *
	 * @param array $options Query options
	 *
	 * @return array
	 */
	public function getQueryOptions(array $options = []) {
		return $options;
	}

	/**
	 * Get default list view options
	 *
	 * @param array $options List view options
	 *
	 * @return mixed
	 */
	public function getListOptions(array $options = []) {
		return array_merge([
			'list_class' => 'elgg-list-river',
			'no_results' => elgg_echo('activity:no_results'),
		], $options);
	}

	/**
	 * Returns base URL of the collection
	 *
	 * @return string
	 */
	public function getURL() {
		return elgg_generate_url('collection:river:all');
	}


	/**
	 * Get menu items related to the collection
	 * @return \ElggMenuItem[]
	 */
	public function getMenu() {
		return [];
	}
}