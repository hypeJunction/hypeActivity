<?php

namespace hypeJunction\Activity;

use ElggEntity;
use hypeJunction\Data\CollectionAdapter;
use hypeJunction\Lists\CollectionInterface;
use hypeJunction\Lists\SearchFieldInterface;

abstract class Collection implements CollectionInterface {

	/**
	 * @var \ElggEntity
	 */
	protected $target;

	/**
	 * @var array
	 */
	protected $params;

	/**
	 * @var array
	 */
	protected $sorts = [];

	/**
	 * @var array
	 */
	protected $filters = [];

	/**
	 * @var string
	 */
	protected $query = '';

	/**
	 * Constructor
	 *
	 * @param \ElggEntity $target Target entity of the collection
	 * @param array       $params Request params
	 */
	public function __construct(\ElggEntity $target = null, array $params = []) {
		$this->target = $target;
		$this->params = $params;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTarget() {
		return $this->target;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function getList(array $options = []) {
		$options = $this->getQueryOptions($options);

		if (!isset($options['limit'])) {
			$limit = get_input('limit');
			if (!isset($limit)) {
				$limit = 20;
			}
			$options['limit'] = $limit;
		}

		if (!isset($options['offset'])) {
			$options['offset'] = get_input('offset', 0);
		}

		$list = new ActivityList($options);

		foreach ($this->sorts as $sort) {
			$list->addSort($sort->field, $sort->direction, $sort->as);
		}

		foreach ($this->filters as $filter) {
			$list->addFilter($filter->filter, $filter->target, $filter->params);
		}

		$list->setSearchQuery($this->query);

		return $list;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function addSort($class, $direction = null, $as = null) {
		$this->sorts[] = (object) [
			'field' => $class,
			'direction' => $direction,
			'as' => $as,
		];

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function getSorts() {
		return $this->sorts;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function addFilter($class, ElggEntity $target = null, array $params = []) {
		$this->filters[] = (object) [
			'filter' => $class,
			'target' => $target,
			'params' => $params,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	final public function getFilters() {
		return $this->filters;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function setSearchQuery($query = '') {
		$this->query = $query;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function getSearchQuery() {
		return $this->query;
	}

	/**
	 * {@inheritdoc}
	 */
	final public function render(array $vars = []) {
		$vars = $this->getListOptions($vars);

		$list = $this->getList();

		$limit = $list->getOptions()->limit;
		$offset = $list->getOptions()->offset;

		$vars['limit'] = $limit;
		$vars['offset'] = $offset;

		$vars['items'] = $list->get($limit, $offset);
		$vars['count'] = $list->count();

		$query = _elgg_services()->request->getParams();
		unset($query['limit']);
		unset($query['offset']);
		unset($query['_route']);

		$vars['base_url'] = elgg_http_add_url_query_elements($this->getURL(), $query);
		$vars['list_id'] = md5($this->getURL());

		return elgg_view('collection/list', $vars);
	}

	/**
	 * {@inheritdoc}
	 */
	final public function export() {

		$list = $this->getList();
		$options = $list->getOptions()->getArrayCopy();

		$adapter = new \hypeJunction\Activity\CollectionAdapter($options);
		$data = $adapter->export($this->params);

		return $data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSortOptions() {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilterOptions() {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSearchOptions() {
		return [
			TypeSubtypeSearchField::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	final public function getSearchFields() {
		$classes = $this->getSearchOptions();

		$fields = [];

		foreach ($classes as $class) {
			if (!is_subclass_of($class, SearchFieldInterface::class)) {
				throw new \InvalidParameterException($class . ' must implement ' . SearchFieldInterface::class);
			}

			/* @var $class \hypeJunction\Lists\SearchFieldInterface */

			$fields[] = new $class($this);
		}

		$params = $this->params;
		$params['collection'] = $this;

		return elgg_trigger_plugin_hook('search:fields', $this->getId(), $params, $fields);
	}
}