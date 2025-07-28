<?php
use Psr\Log\LogLevel;

$event_guid = (int) elgg_extract('event_guid', $vars);
$event = get_entity($event_guid);

if (!$event || $event->getSubtype() !== 'event') {
    elgg_log('Event Carpool: Ongeldig evenement voor add_offer, GUID: ' . $event_guid, LogLevel::ERROR);
    return;
}

if (!elgg_is_logged_in()) {
    echo elgg_echo('event_carpool:login_required');
    return;
}

elgg_log('Event Carpool: Render add_offer form voor event GUID ' . $event_guid, LogLevel::NOTICE);

$form_vars = [
    'id' => 'carpool-add-offer-form',
    'class' => 'elgg-form',
    'action' => elgg_generate_action_url('event_carpool/add_offer'),
];

$body_vars = [
    'event_guid' => $event_guid,
];

echo elgg_view_form('event_carpool/add_offer', $form_vars, $body_vars);