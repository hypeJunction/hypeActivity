<?php

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$elements = [];

$time = elgg_extract('time', $vars);
if (!isset($time)) {
	$time = $item->getTimePosted();
}

$elements[] = elgg_view('object/elements/imprint/element', [
	'icon_name' => elgg_extract('time_icon', $vars, 'history'),
	'content' => elgg_view_friendly_time($time),
	'class' => 'elgg-river-time',
]);

// if activity happened in a group
$group_string = '';
$container = $item->getTargetEntity();
if (!$container) {
	$object = $item->getObjectEntity();
	if ($object) {
		$container = $object->getContainerEntity();
	}
}

if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', [
		'href' => $container->getURL(),
		'text' => $container->getDisplayName(),
		'is_trusted' => true,
	]);

	$elements[] = elgg_view('object/elements/imprint/element', [
		'icon_name' => elgg_extract('group_icon', $vars, 'users'),
		'content' => $group_link,
		'class' => 'elgg-river-group',
	]);
}


echo elgg_format_element('div', [
	'class' => 'elgg-river-imprint elgg-subtitle',
], implode(' ', $elements));

