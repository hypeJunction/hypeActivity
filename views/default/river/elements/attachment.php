<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

$view = '';

if ($entity instanceof ElggFile) {
	$mime = $entity->getMimeType();
	$base_type = substr($mime, 0, strpos($mime, '/'));

	$vars['full_view'] = true;
	$view = '';
	if (elgg_view_exists("file/specialcontent/$mime")) {
		$view = elgg_view("file/specialcontent/$mime", $vars);
	} elseif (elgg_view_exists("file/specialcontent/$base_type/default")) {
		$view = elgg_view("file/specialcontent/$base_type/default", $vars);
	}
}

if (!$view) {
	$view = elgg_view_entity($entity, [
		'full_view' => false,
		'item_view' => "attachment/$entity->type/$entity->subtype",
		'metadata' => false,
	]);
}

echo elgg_format_element('div', [
	'class' => 'elgg-river-attachment',
], $view);