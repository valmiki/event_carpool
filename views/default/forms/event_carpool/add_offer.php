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
    '#type' => 'number',
    '#label' => elgg_echo('event_carpool:seats'),
    'name' => 'seats',
    'required' => true,
    'min' => 1,
]);

echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('event_carpool:pickup_points'),
    'name' => 'pickup_points',
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'textarea',
    '#label' => elgg_echo('event_carpool:notes'),
    'name' => 'notes',
]);

echo elgg_view_field([
    '#type' => 'submit',
    '#text' => elgg_echo('event_carpool:add_offer'),
    'value' => 'submit',
]);