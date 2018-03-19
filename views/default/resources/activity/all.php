<?php

$request = elgg_extract('request', $vars);

$svc = elgg()->activity;
/* @var $svc \hypeJunction\Activity\Activity */

$collections = elgg()->collections;
/* @var $collections \hypeJunction\Lists\Collections */

$collection = $collections->build("collection:river:all", null, $request->getParams());
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

$filter = elgg_view('river/filter', $vars);
$sidebar = elgg_view('river/sidebar/all', $vars);

$body = elgg_view_layout('default', [
	'title' => false,
	'content' =>  $filter . $activity,
	'filter_id' => 'river',
	'filter_value' => 'all',
	'sidebar' => $sidebar ? : false,
	'class' => 'elgg-river-layout',
]);

$title = elgg_echo('river:all');
echo elgg_view_page($title, $body);
