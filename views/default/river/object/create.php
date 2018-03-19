<?php
/**
 * Default river view for ElggObject creation
 * Will show an excerpt of the description of the ElggObject
 *
 * @uses $vars['item'] the river item
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
if (!$object instanceof ElggObject) {
	return;
}

$vars['attachments'] = elgg_view('river/elements/attachment', [
	'entity' => $object,
	'item' => $item,
]);

echo elgg_view('river/elements/layout', $vars);
