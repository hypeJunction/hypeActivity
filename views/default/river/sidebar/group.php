<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view('river/sidebar', $vars);

if (!$entity instanceof ElggGroup) {
	return;
}

if ($entity->canAccessContent()) {
	echo elgg_view('post/template/default/sidebar', $vars);
}