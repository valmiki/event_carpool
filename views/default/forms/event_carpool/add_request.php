<?php

$event_guid = (int) elgg_extract('event_guid', $vars);
if (!$event_guid) {
	return;
}

echo elgg_view_field([
	'#type'  => 'hidden',
	'name'   => 'event_guid',
	'value'  => $event_guid,
]);

echo elgg_view_field([
	'#type'     => 'number',
	'#label'    => elgg_echo('event_carpool:seats_needed'),
	'name'      => 'seats_needed',
	'required'  => true,
	'min'       => 1,
]);

echo elgg_view_field([
	'#type'     => 'text',
	'#label'    => elgg_echo('event_carpool:pickup_location'),
	'name'      => 'pickup_location',
	'required'  => true,
]);

echo elgg_view_field([
	'#type'  => 'plaintext',
	'#label' => elgg_echo('event_carpool:notes'),
	'name'   => 'notes',
	'rows'   => 4,
]);

echo elgg_view('input/submit', [
	'value'      => elgg_echo('event_carpool:add_request'),
	'text'       => elgg_echo('event_carpool:add_request'),
	'title'      => elgg_echo('event_carpool:add_request'),
	'aria-label' => elgg_echo('event_carpool:add_request'),
]);
