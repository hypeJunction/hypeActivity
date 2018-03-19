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

$data = $collection->export();

elgg_set_http_header('Content-Type: application/json');

echo json_encode($data);