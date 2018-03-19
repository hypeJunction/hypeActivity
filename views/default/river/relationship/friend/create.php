<?php
/**
 * Create friend river view
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

if (!$subject instanceof ElggUser || !$object instanceof ElggUser) {
	return;
}

$vars['attachments'] = elgg_view('river/elements/attachment', [
	'entity' => $object,
	'item' => $item,
]);

$vars['responses'] = false;

echo elgg_view('river/elements/layout', $vars);
