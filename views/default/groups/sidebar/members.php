<?php
/**
 * Group members sidebar
 *
 * @package ElggGroups
 *
 * @uses    $vars['entity'] Group entity
 * @uses    $vars['limit']  The number of members to display
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggGroup) {
	return;
}

$count = $entity->getMembers(['count' => true]);
if (!$count) {
	return;
}

$limit = elgg_extract('limit', $vars, 14);

$all_link = elgg_view('output/url', [
	'href' => elgg_generate_url('collection:user:user:group_members', [
		'guid' => $entity->guid,
	]),
	'text' => elgg_echo('link:view:all'),
]);

$body = elgg_list_entities([
	'relationship' => 'member',
	'relationship_guid' => $entity->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => $limit,
	'order_by' => 'r.time_created DESC',
	'pagination' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
]);

$badge = elgg_format_element('span', ['class' => 'elgg-badge elgg-state-info'], $count);

echo elgg_view('groups/profile/module', [
	'all_link' => $all_link,
	'content' => $body,
	'title' => elgg_echo('groups:members') . $badge,
]);
