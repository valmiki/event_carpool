<?php
use Psr\Log\LogLevel;

$event_guid = (int) get_input('event_guid');
$seats_needed = (int) get_input('seats_needed');
$pickup_location = get_input('pickup_location');
$notes = get_input('notes');

\elgg_log('Event Carpool: Poging tot toevoegen van verzoek voor event GUID ' . $event_guid, LogLevel::NOTICE);

$event = get_entity($event_guid);
if (!$event || $event->getSubtype() !== 'event') {
    \elgg_log('Event Carpool: Ongeldig evenement GUID ' . $event_guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_event'), [], 404);
}

if ($seats_needed < 1 || empty($pickup_location)) {
    \elgg_log('Event Carpool: Ongeldige invoer voor verzoek: seats_needed=' . $seats_needed . ', pickup_location=' . $pickup_location, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_input'), [], 400);
}

$request = new \ElggObject();
$request->subtype = 'carpool_request';
$request->owner_guid = elgg_get_logged_in_user_guid();
$request->container_guid = $event_guid;
$request->access_id = $event->access_id;
$request->seats_needed = $seats_needed;
$request->pickup_location = $pickup_location;
$request->notes = $notes;

try {
    if ($request->save()) {
        \elgg_create_relationship($request->guid, 'for_event', $event_guid);
        \elgg_log('Event Carpool: Verzoek GUID ' . $request->guid . ' succesvol toegevoegd voor event GUID ' . $event_guid, LogLevel::NOTICE);
        return elgg_ok_response('', elgg_echo('event_carpool:request:success'));
    } else {
        \elgg_log('Event Carpool: Mislukt om verzoek te bewaren voor event GUID ' . $event_guid, LogLevel::ERROR);
        return elgg_error_response(elgg_echo('event_carpool:error:save_failed'), [], 500);
    }
} catch (Exception $e) {
    \elgg_log('Event Carpool: Uitzondering bij toevoegen verzoek voor event GUID ' . $event_guid . ': ' . $e->getMessage(), LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:save_failed'), [], 500);
}