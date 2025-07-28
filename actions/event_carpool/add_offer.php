<?php
use Psr\Log\LogLevel;

$event_guid = (int) get_input('event_guid');
$seats = (int) get_input('seats');
$pickup_points = get_input('pickup_points');
$notes = get_input('notes');

\elgg_log('Event Carpool: Poging tot toevoegen van aanbieding voor event GUID ' . $event_guid, LogLevel::NOTICE);

$event = get_entity($event_guid);
if (!$event || $event->getSubtype() !== 'event') {
    \elgg_log('Event Carpool: Ongeldig evenement GUID ' . $event_guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_event'), [], 404);
}

if ($seats < 1 || empty($pickup_points)) {
    \elgg_log('Event Carpool: Ongeldige invoer voor aanbieding: seats=' . $seats . ', pickup_points=' . $pickup_points, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_input'), [], 400);
}

$offer = new \ElggObject();
$offer->setSubtype('carpool_offer'); // Gebruik setSubtype() i.p.v. magic setter
$offer->owner_guid = elgg_get_logged_in_user_guid();
$offer->container_guid = $event_guid;
$offer->access_id = $event->access_id;
$offer->seats = $seats;
$offer->pickup_points = $pickup_points;
$offer->notes = $notes;
$offer->status = 'open';

try {
    if ($offer->save()) {
        \elgg_create_relationship($offer->guid, 'for_event', $event_guid);
        \elgg_log('Event Carpool: Aanbieding GUID ' . $offer->guid . ' succesvol toegevoegd voor event GUID ' . $event_guid, LogLevel::NOTICE);
        return elgg_ok_response('', elgg_echo('event_carpool:offer:success'));
    } else {
        \elgg_log('Event Carpool: Mislukt om aanbieding te bewaren voor event GUID ' . $event_guid, LogLevel::ERROR);
        return elgg_error_response(elgg_echo('event_carpool:error:save_failed'), [], 500);
    }
} catch (Exception $e) {
    \elgg_log('Event Carpool: Uitzondering bij toevoegen aanbieding voor event GUID ' . $event_guid . ': ' . $e->getMessage(), LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:save_failed'), [], 500);
}