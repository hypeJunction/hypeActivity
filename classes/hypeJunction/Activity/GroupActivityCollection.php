<?php

namespace hypeJunction\Activity;

class GroupActivityCollection extends DefaultActivityCollection {

	/**
	 * Get ID of the collection
	 * @return string
	 */
	public function getId() {
		return 'collection:river:group';
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
		$entity = $this->getTarget();

		$options = array_merge([
			'wheres' => [
				function (\Elgg\Database\QueryBuilder $qb, $from_alias) use ($entity) {
					$a1 = $qb->joinEntitiesTable($from_alias, 'object_guid');
					$a2 = $qb->joinEntitiesTable($from_alias, 'target_guid', 'left');

					return $qb->merge([
						$qb->compare("$a1.container_guid", '=', $entity->guid, ELGG_VALUE_GUID),
						$qb->compare("$a2.container_guid", '=', $entity->guid, ELGG_VALUE_GUID),
					], 'OR');
				},
			],
		], $options);

		return parent::getQueryOptions($options);
	}

	/**
	 * Returns base URL of the collection
	 *
	 * @return string
	 */
	public function getURL() {
		return elgg_generate_url('collection:river:group', [
			'guid' => $this->getTarget()->guid,
		]);
	}
}