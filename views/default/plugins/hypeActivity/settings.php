<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'checkbox',
	'switch' => true,
	'#label' => elgg_echo('activity:settings:gatekeeper'),
	'#help' => elgg_echo('activity:settings:gatekeeper:help'),
	'name' => 'params[gatekeeper]',
	'default' => 0,
	'value' => 1,
	'checked' => (bool) $entity->gatekeeper,
]);