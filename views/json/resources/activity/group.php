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

$data = [];

if ($entity->canAccessContent()) {
	$data = $collection->export();
}

elgg_set_http_header('Content-Type: application/json');

echo json_encode($data);