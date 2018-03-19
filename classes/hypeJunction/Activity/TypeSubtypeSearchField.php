<?php

namespace hypeJunction\Activity;

use hypeJunction\Lists\CollectionInterface;
use hypeJunction\Lists\SearchFieldInterface;
use hypeJunction\Lists\SearchFields\SearchField;

class TypeSubtypeSearchField extends SearchField {

	/**
	 * Returns field name
	 * @return string
	 */
	public function getName() {
		return 'filter';
	}

	/**
	 * Returns field parameters
	 * @return array|null
	 */
	public function getField() {

		$svc = elgg()->activity;
		/* @var $svc Activity */

		$filters = $svc->getFilters();

		$options = [];
		foreach ($filters as $filter) {
			$options[$filter->id] = $filter->label;
		}

		return [
			'#type' => 'select',
			'name' => $this->getName(),
			'value' => $this->getValue(),
			'options_values' => $options,
			'config' => [
				'allowClear' => true,
			],
		];
	}

	/**
	 * Set constraints on the collection based on field value
	 * @return void
	 */
	public function setConstraints() {
		$value = $this->getValue();
		if (!$value) {
			return;
		}

		$svc = elgg()->activity;
		/* @var $svc Activity */

		$filter = $svc->getFilter($value);

		if (!$filter) {
			return;
		}

		$this->collection->addFilter($filter->handler, null, $this->collection->getParams());
	}
}