<?php

namespace hypeJunction\Activity;

class CollectionItemAdapter {

	/**
	 * @var \ElggRiverItem
	 */
	private $item;

	/**
	 * Entity constructor.
	 *
	 * @param \ElggRiverItem $item River item
	 */
	public function __construct(\ElggRiverItem $item) {
		$this->item = $item;
	}

	/**
	 * Export an entity
	 *
	 * @param array $params Export params
	 *
	 * @return array
	 */
	public function export(array $params = []) {

		$viewtype = elgg_get_viewtype();
		elgg_set_viewtype('default');

		$data = (array) $this->item->toObject();
		$data['summary'] = elgg_view('river/elements/summary', [
			'item' => $this->item,
		]);

		$type = $this->item->type;
		$subtype = $this->item->subtype;

		$params['item'] = $this->item;

		$data = elgg_trigger_plugin_hook('adapter:entity', "$type:$subtype", $params, $data);
		$data = elgg_trigger_plugin_hook('adapter:entity', $type, $params, $data);

		$expand = function($elem) use ($params, &$expand) {
			if ($elem instanceof \ElggEntity) {
				$adapter = new \hypeJunction\Data\CollectionItemAdapter($elem);
				return $adapter->export($params);
			} else if (is_array($elem)) {
				foreach ($elem as $key => $value) {
					$elem[$key] = $expand($value);
				}
			}

			return $elem;
		};

		elgg_set_viewtype($viewtype);

		return $expand($data);
	}
}
