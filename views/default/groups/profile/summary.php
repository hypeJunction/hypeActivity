<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['entity']
 */

$group = elgg_extract('entity', $vars);
if (!($group instanceof \ElggGroup)) {
	echo elgg_echo('groups:notfound');
	return;
}

echo elgg_format_element('div', [
	'class' => 'groups-profile-fields',
], elgg_view('groups/profile/fields', $vars));
