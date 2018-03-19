<?php

echo elgg_view('river/sidebar', $vars);

if (!elgg_is_logged_in()) {
	echo elgg_view('core/account/login_box');
	return;
}

elgg_push_context('dashboard');

echo elgg_view_layout('widgets', [
	'num_columns' => 1,
	'owner_guid' => elgg_get_logged_in_user_guid(),
]);

elgg_pop_context();