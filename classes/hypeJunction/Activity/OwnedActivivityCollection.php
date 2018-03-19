<?php

namespace hypeJunction\Activity;

class OwnedActivivityCollection extends DefaultActivityCollection {

	/**
	 * Get ID of the collection
	 * @return string
	 */
	public function getId() {
		return 'collection:river:owner';
	}

	/**
	 * Get the type of collection, e.g. owner, friends, group all
	 * @return string
	 */
	public function getCollectionType() {
		return 'owner';
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
			'subject_guids' => $this->getTarget()->guid,
		], $options);

		return parent::getQueryOptions($options);
	}

	/**
	 * Returns base URL of the collection
	 *
	 * @return string
	 */
	public function getURL() {
		return elgg_generate_url('collection:river:owner', [
			'username' => $this->getTarget()->username,
		]);
	}
}