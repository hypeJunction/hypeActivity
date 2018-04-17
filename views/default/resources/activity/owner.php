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

$collection = $collections->build("collection:river:owner", $entity, $request->getParams());
/* @var $collection \hypeJunction\Lists\CollectionInterface */

if (!$collection) {
	throw new \Elgg\PageNotFoundException();
}

elgg_push_context('activity');
$activity = elgg_view('collection/view', [
	'collection' => $collection,
]);
elgg_pop_context();

if ($request->isXhr()) {
	echo $activity;
	return;
}

$vars['entity'] = $entity;

$svc = elgg()->activity;
/* @var $svc \hypeJunction\Activity\Activity */

elgg_push_context('activity');
$content = elgg_view('profile/wrapper', $vars);
$content .= elgg_view('page/components/wall', [
	'container' => $entity,
]);
$content .= elgg_view('river/filter', $vars);
$content .= $activity;
elgg_pop_context();

$sidebar = elgg_view('river/sidebar/owner', $vars);

$body = elgg_view_layout('default', [
	'title' => false,
	'content' =>  $content,
	'filter_id' => 'river',
	'filter_value' => $entity->guid == elgg_get_logged_in_user_guid() ? 'mine' : 'none',
	'sidebar' => $sidebar ? : false,
	'class' => 'elgg-river-layout',
]);

echo elgg_view_page($entity->getDisplayName(), $body);
