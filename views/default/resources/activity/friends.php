<?php

$request = elgg_extract('request', $vars);
/* @var $request \Elgg\Request */

$username = $request->getParam('username');

$entity = get_user_by_username($username);
if (!$entity) {
	throw new \Elgg\EntityNotFoundException();
}

elgg_entity_gatekeeper($entity->guid, 'user');

$collections = elgg()->collections;
/* @var $collections \hypeJunction\Lists\Collections */

$collection = $collections->build("collection:river:friends", $entity, $request->getParams());
/* @var $collection \hypeJunction\Lists\CollectionInterface */

if (!$collection) {
	throw new \Elgg\PageNotFoundException();
}

$activity = elgg_view('collection/view', [
	'collection' => $collection,
]);

if ($request->isXhr()) {
	echo $activity;
	return;
}

$vars['entity'] = $entity;

elgg_push_context('activity');
$content .= elgg_view('river/filter', $vars);
$content .= $activity;
elgg_pop_context();

$sidebar = elgg_view('river/sidebar/friends', $vars);

$body = elgg_view_layout('default', [
	'title' => $collection->getDisplayName(),
	'content' =>  $content,
	'filter_id' => 'river/friends',
	'sidebar' => $sidebar ? : false,
	'class' => 'elgg-river-layout',
]);

echo elgg_view_page($entity->getDisplayName(), $body);
