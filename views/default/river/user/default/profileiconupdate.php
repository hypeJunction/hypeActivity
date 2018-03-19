<?php
/**
 * Update avatar river view
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$subject = $item->getSubjectEntity();
if (!$subject instanceof ElggUser) {
	return;
}

$subject_link = elgg_view('output/url', [
	'href' => $subject->getURL(),
	'text' => $subject->getDisplayName(),
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
]);

$vars['summary'] = elgg_echo('river:update:user:avatar', [$subject_link]);

$image = elgg_view_entity_icon($subject, 'large', [
	'use_hover' => false,
	'use_link' => false,
]);

$vars['attachments'] = elgg_format_element('div', [
	'class' => 'elgg-river-attachment',
], $image);

$vars['responses'] = false;

echo elgg_view('river/elements/layout', $vars);
