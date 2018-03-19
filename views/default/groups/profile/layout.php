<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggGroup) {
	return;
}

if ($entity->canAccessContent()) {
	if (!$entity->isPublicMembership() && !$entity->isMember()) {
		echo elgg_view('groups/profile/closed_membership');
	}
} else {
	if ($entity->isPublicMembership()) {
		echo elgg_view('groups/profile/membersonly_open');
	} else {
		echo elgg_view('groups/profile/membersonly_closed');
	}
}

echo elgg_view('groups/profile/summary', $vars);
