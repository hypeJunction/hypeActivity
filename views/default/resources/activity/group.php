<?php


$request = elgg_extract('request', $vars);
/* @var $request \Elgg\Request */

$guid = $request->getParam('guid');
elgg_entity_gatekeeper($guid, 'group');

$entity = get_entity($guid);

$collections = elgg()->collections;
/* @var $collections \hypeJunction\Lists\Collections */

$collection = $collections->build("collection:river:group", $entity, $request->getParams());
/* @var $collection \hypeJunction\Lists\CollectionInterface */

if (!$collection) {
	throw new \Elgg\PageNotFoundException();
}

$activity = '';
if ($entity->canAccessContent()) {
	$activity = elgg_view('collection/view', [
		'collection' => $collection,
	]);
}

if ($request->isXhr()) {
	echo $activity;

	return;
}

$vars['entity'] = $entity;

elgg_push_context('activity');

$content = elgg_view('groups/profile/layout', $vars);

if ($entity->canAccessContent()) {
	$content .= elgg_view('page/components/wall', [
		'container' => $entity,
	]);
	$content .= elgg_view('river/filter', $vars);
	$content .= $activity;
}

elgg_pop_context();

$sidebar = elgg_view('river/sidebar/group', $vars);

$body = elgg_view_layout('default', [
	'title' => false,
	'content' => $content,
	'sidebar' => $sidebar ? : false,
	'class' => 'elgg-river-layout',
]);

echo elgg_view_page($entity->getDisplayName(), $body);