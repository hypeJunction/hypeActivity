<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view('river/sidebar', $vars);

if (!$entity instanceof ElggGroup) {
	return;
}

if ($entity->canAccessContent()) {
	echo elgg_view('groups/sidebar/members', $vars);
	echo elgg_view('groups/profile/widgets', $vars);
	echo elgg_view('groups/sidebar/search', $vars);
	echo elgg_view('post/template/default/sidebar', $vars);
}