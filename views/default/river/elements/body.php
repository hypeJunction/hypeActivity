<?php
/**
 * Body of river item
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['summary']     Alternate summary (the short text summary of action)
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate respones (comments, replies, etc.)
 */

$item = elgg_extract('item', $vars);
if (!($item instanceof \ElggRiverItem)) {
	return;
}

// metadata (eg. menus)
$metadata = elgg_extract('metadata', $vars);
if (!isset($metadata)) {
	$metadata = elgg_view_menu('river', [
		'item' => $item,
	]);
	
	$object = $item->getObjectEntity();
	if ($object) {
		$metadata .= elgg_view_menu('social', [
			'entity' => $object,
			'item' => $item,
			'class' => 'elgg-menu-hz',
		]);
	}
}

if (!empty($metadata)) {
	echo elgg_format_element('div', [
		'class' => 'elgg-river-metadata',
	], $metadata);
}

$summary = elgg_extract('summary', $vars);
if (!isset($summary)) {
	$summary = elgg_view('river/elements/summary', $vars);
}

if ($summary === false) {
	$subject = $item->getSubjectEntity();
	if ($subject instanceof ElggEntity) {
		$summary = elgg_view('output/url', [
			'href' => $subject->getURL(),
			'text' => $subject->getDisplayName(),
			'class' => 'elgg-river-subject',
			'is_trusted' => true,
		]);
	}
}

if (!empty($summary)) {
	$summary = elgg_format_element('div', ['class' => 'elgg-river-summary'], $summary);
}

$summary .= elgg_view('river/elements/imprint', $vars);

$image = elgg_view('river/elements/image', $vars);

echo elgg_view_image_block($image, $summary, [
	'class' => 'elgg-river-header',
]);

// message (eg excerpt)
$message = elgg_extract('message', $vars);
if (!empty($message)) {
	echo elgg_format_element('div', ['class' => 'elgg-river-message',], $message);
}

// attachments
$attachments = elgg_extract('attachments', $vars);
if (!empty($attachments)) {
	echo elgg_format_element('div', [
		'class' => [
			'elgg-river-attachments',
			'clearfix',
		],
	], $attachments);
}

// responses (eg. comments)
$responses = elgg_view('river/elements/responses', $vars);
if (!empty($responses)) {
	echo elgg_format_element('div', ['class' => 'elgg-river-responses',], $responses);
}
