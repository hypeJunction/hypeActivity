<?php
/**
 * Layout of a river item
 *
 * @uses $vars['item'] ElggRiverItem
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$body = elgg_view('river/elements/body', $vars);

echo elgg_format_element('div', [
	'class' => 'elgg-river-item',
], $body);
