<?php

$event_guid = elgg_extract('event_guid', $vars);
if (!$event_guid) {
    return;
}

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'event_guid',
    'value' => $event_guid,
]);

echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('event_carpool:pickup_location'),
    'name' => 'pickup_location',
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'number',
    '#label' => elgg_echo('event_carpool:seats_needed'),
    'name' => 'seats_needed',
    'required' => true,
    'min' => 1,
]);

echo elgg_view_field([
    '#type' => 'textarea',
    '#label' => elgg_echo('event_carpool:notes'),
    'name' => 'notes',
]);

echo elgg_view_field([
    '#type' => 'submit',
    '#text' => elgg_echo('event_carpool:add_request'),
    'value' => 'add',
]);