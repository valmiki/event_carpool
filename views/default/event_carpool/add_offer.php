<?php

$event_guid = (int) elgg_extract('event_guid', $vars);
$event = get_entity($event_guid);

if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	return;
}

if (!elgg_is_logged_in()) {
	echo elgg_view_module('info', elgg_echo('event_carpool:add_offer'), elgg_echo('event_carpool:login_required'));
	return;
}

$form = elgg_view_form('event_carpool/add_offer', [
	'id'     => 'event-carpool-add-offer-form',
	'action' => elgg_generate_action_url('event_carpool/add_offer'),
	'class'  => 'elgg-form',
], [
	'event_guid' => $event_guid,
]);

echo elgg_view_module('info', elgg_echo('event_carpool:add_offer'), $form, [
	'class' => 'event-carpool-add-offer',
]);
