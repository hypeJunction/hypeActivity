<?php

namespace hypeJunction\Activity;

class CollectionAdapter {

	const MAX_ITEMS = 100;

	/**
	 * @var array
	 */
	private $options;

	/**
	 * Constructor
	 *
	 * @param array $options ege* options
	 */
	public function __construct(array $options = []) {
		$this->options = $options;
	}

	/**
	 * Export a list
	 *
	 * @param array $params Export params
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function export(array $params = []) {

		$viewtype = elgg_get_viewtype();
		elgg_set_viewtype('default');

		$list = $this->getList();

		$limit = $list->getOptions()->limit;
		$offset = $list->getOptions()->offset;

		if ($limit > self::MAX_ITEMS) {
			$limit = self::MAX_ITEMS;
		}

		$batch = $list->batch($limit, $offset);

		$data = [
			'count' => (int) $batch->count(),
			'limit' => (int) $limit,
			'offset' => (int) $offset,
			'items' => [],
			'_related' => [],
		];

		foreach ($batch as $river_item) {
			$adapter = new CollectionItemAdapter($river_item);
			$data['items'][] = $adapter->export($params);

			if ($subject = $river_item->getSubjectEntity()) {
				if (!isset($data['_related'][$subject->guid])) {
					$adapter = new \hypeJunction\Data\CollectionItemAdapter($subject);
					$data['_related'][$subject->guid] = $adapter->export($params);
				}
			}

			if ($object = $river_item->getObjectEntity()) {
				if (!isset($data['_related'][$object->guid])) {
					$adapter = new \hypeJunction\Data\CollectionItemAdapter($object);
					$data['_related'][$object->guid] = $adapter->export($params);
				}
			}

			if ($target = $river_item->getTargetEntity()) {
				if (!isset($data['_related'][$target->guid])) {
					$adapter = new \hypeJunction\Data\CollectionItemAdapter($target);
					$data['_related'][$target->guid] = $adapter->export($params);
				}
			}
		}

		$data['_related'] = array_values($data['_related']);

		$url = current_page_url();
		$url = substr($url, strlen(elgg_get_site_url()));
		if ($data['count'] && $offset > 0) {
			$prev_offset = $offset - $limit;
			if ($prev_offset < 0) {
				$prev_offset = 0;
			}

			$data['_links']['prev'] = elgg_http_add_url_query_elements($url, [
				'offset' => $prev_offset,
			]);
		} else {
			$data['_links']['prev'] = false;
		}

		if ($data['count'] > $limit + $offset) {
			$next_offset = $offset + $limit;
			$data['_links']['next'] = elgg_http_add_url_query_elements($url, [
				'offset' => $next_offset,
			]);
		} else {
			$data['_links']['next'] = false;
		}

		elgg_set_viewtype($viewtype);

		return $data;
	}

	/**
	 * Prepare an entity list with search, sort and filter constraints
	 *
	 * @param array $options Options
	 *
	 * @return ActivityList
	 */
	protected function getList() {

		$filter = elgg_extract('filter', $this->options, get_input('filter'));
		$query = elgg_extract('query', $this->options, get_input('query'));
		$sort = elgg_extract('sort', $this->options, get_input('sort'));
		$target = elgg_extract('filter_target', $this->options);
		unset($this->options['filter_target']);

		if (is_numeric($target)) {
			$target = get_entity($target);
		}

		if (!$target instanceof \ElggEntity) {
			$target = null;
		}

		list($sort_field, $sort_direction) = explode('::', $sort);

		$list = new ActivityList($this->options);

		if ($sort_field) {
			$list->addSort($sort_field, $sort_direction);
		}

		if ($filter) {
			$list->addFilter($filter, $target);
		}

		if ($query) {
			$list->setSearchQuery($query);
		}

		return $list;
	}
}
