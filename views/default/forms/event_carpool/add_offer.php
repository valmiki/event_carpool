<?php

$event_guid = (int) elgg_extract('event_guid', $vars);
if (!$event_guid) {
    return;
}

echo elgg_view('input/hidden', [
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
    '#type' => 'plaintext', // tijdelijk als fallback
    '#label' => elgg_echo('event_carpool:notes'),
    'name' => 'notes',
    'rows' => 4,
]);

echo elgg_view('input/submit', [
    'text' => elgg_echo('event_carpool:add_offer'),
    'value' => elgg_echo('event_carpool:add_offer'),
    'title' => elgg_echo('event_carpool:add_offer'),
    'aria-label' => elgg_echo('event_carpool:add_offer'),
]);