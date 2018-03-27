<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view('river/sidebar', $vars);

elgg_push_context('profile');

echo elgg_view_layout('widgets', [
	'num_columns' => 1,
	'owner_guid' => $entity->guid,
]);

elgg_pop_context();

echo elgg_view('post/template/default/sidebar', $vars);