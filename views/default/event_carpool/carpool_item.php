<?php
/**
 * Renders a single carpool offer OR request (item view for both).
 */

use Psr\Log\LogLevel;

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggEntity) {
	elgg_log('event_carpool: carpool_item received no valid entity', LogLevel::NOTICE);
	return;
}

$is_offer = $entity->getSubtype() === 'event_carpool_offer';

if ($is_offer) {
	$seats         = (int) $entity->seats;
	$pickup_label  = elgg_echo('event_carpool:pickup_points');
	$pickup_value  = (string) ($entity->pickup_points ?? '');
	$title_key     = 'event_carpool:offer_by';
	$toggle_class  = 'carpool-offer-toggle';
	$details_class = 'carpool-offer-details';
	$close_action  = 'event_carpool/close_offer';
	$delete_action = 'event_carpool/delete_offer';
} else {
	$seats         = (int) $entity->seats_needed;
	$pickup_label  = elgg_echo('event_carpool:pickup_location');
	$pickup_value  = (string) ($entity->pickup_location ?? '');
	$title_key     = 'event_carpool:request_by';
	$toggle_class  = 'carpool-request-toggle';
	$details_class = 'carpool-request-details';
	$close_action  = 'event_carpool/close_request';
	$delete_action = 'event_carpool/delete_request';
}

$notes     = (string) ($entity->notes ?? '');
$is_closed = ($entity->status === 'closed');

$owner      = $entity->getOwnerEntity();
$owner_name = $owner ? htmlspecialchars($owner->getDisplayName()) : elgg_echo('unknown');

// Header: "Offered by jans · <pickup>"  (+ Closed badge)
$header = elgg_echo($title_key, [$owner_name]);
if ($pickup_value !== '') {
	$header .= ' · ' . htmlspecialchars($pickup_value);
}
if ($is_closed) {
	$header .= ' ' . elgg_format_element('span', ['class' => 'carpool-badge-closed'], elgg_echo('event_carpool:status_closed'));
}

// Detail rows
$detail_rows = [
	elgg_format_element('p', [], elgg_echo('event_carpool:seats') . ': ' . $seats),
	elgg_format_element('p', [], $pickup_label . ': ' . elgg_view('output/text', ['value' => $pickup_value])),
];
if ($notes !== '') {
	$detail_rows[] = elgg_format_element('p', [], elgg_echo('event_carpool:notes') . ': ' . elgg_view('output/longtext', ['value' => $notes]));
}

// Owner actions (offers AND requests): Close (if open) + Delete
if ($entity->canEdit()) {
	$buttons = '';
	if (!$is_closed) {
		$buttons .= elgg_view('output/url', [
			'href'      => elgg_generate_action_url($close_action, ['guid' => $entity->guid]),
			'text'      => elgg_echo('event_carpool:button:close'),
			'is_action' => true,
			'class'     => 'elgg-button elgg-button-action elgg-carpool-close',
			'data-guid' => $entity->guid,
		]);
	}
	$buttons .= elgg_view('output/url', [
		'href'      => elgg_generate_action_url($delete_action, ['guid' => $entity->guid]),
		'text'      => elgg_echo('event_carpool:button:delete'),
		'is_action' => true,
		'class'     => 'elgg-button elgg-button-delete elgg-carpool-delete',
		'data-guid' => $entity->guid,
	]);
	$detail_rows[] = elgg_format_element('div', ['class' => 'carpool-item-actions'], $buttons);
}

// Respond / contact (offers AND requests): non-owners, only while open
$can_contact = elgg_is_logged_in()
	&& !$is_closed
	&& (!$owner || $owner->guid !== elgg_get_logged_in_user_guid());

if ($can_contact) {
	$detail_rows[] = elgg_format_element('div', ['class' => 'carpool-contact-form'], implode('', [
		elgg_format_element('h5', [], elgg_echo('event_carpool:contact:heading')),
		elgg_view_form('event_carpool/send_feedback', [
			'action' => elgg_generate_action_url('event_carpool/send_feedback'),
			'class'  => 'elgg-form event-carpool-feedback-form',
		], [
			'entity_guid' => $entity->guid,
		]),
	]));
}

// Owner card
$owner_card = '';
if ($owner) {
	$owner_card = elgg_format_element('div', ['class' => 'carpool-owner'], implode('', [
		elgg_view('output/url', [
			'href'  => $owner->getURL(),
			'text'  => elgg_view_entity_icon($owner, 'medium'),
			'class' => 'carpool-owner-photo',
		]),
		elgg_view('output/url', [
			'href'  => $owner->getURL(),
			'text'  => $owner_name,
			'class' => 'carpool-owner-name',
		]),
	]));
}

$root_class = 'carpool-item elgg-item elgg-listing';
if ($is_closed) {
	$root_class .= ' carpool-item-closed';
}

echo elgg_format_element('div', ['class' => $root_class], implode('', [
	elgg_format_element('h4', ['class' => $toggle_class], $header),
	elgg_format_element('div', [
		'class' => $details_class,
		'style' => 'display: none;',
	], elgg_format_element('div', ['class' => 'carpool-details-wrapper'], implode('', [
		elgg_format_element('div', ['class' => 'carpool-details'], implode('', $detail_rows)),
		$owner_card,
	]))),
]));
