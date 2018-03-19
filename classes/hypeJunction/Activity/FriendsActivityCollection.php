<?php

namespace hypeJunction\Activity;

class FriendsActivityCollection extends DefaultActivityCollection {

	/**
	 * Get ID of the collection
	 * @return string
	 */
	public function getId() {
		return 'collection:river:friends';
	}

	/**
	 * Get title of the collection
	 * @return string
	 */
	public function getDisplayName() {
		return elgg_echo('collection:river:friends');
	}

	/**
	 * Get the type of collection, e.g. owner, friends, group all
	 * @return string
	 */
	public function getCollectionType() {
		return 'friends';
	}

	/**
	 * Get default query options
	 *
	 * @param array $options Query options
	 *
	 * @return array
	 */
	public function getQueryOptions(array $options = []) {
		$options = array_merge([
			'relationship_guid' => $this->getTarget()->guid,
			'relationship' => 'friend',
		], $options);

		return parent::getQueryOptions($options);
	}

	/**
	 * Returns base URL of the collection
	 *
	 * @return string
	 */
	public function getURL() {
		return elgg_generate_url('collection:river:friends', [
			'username' => $this->getTarget()->username,
		]);
	}
}