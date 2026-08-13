<?php
use Psr\Log\LogLevel;

elgg_gatekeeper();

$guid = (int) get_input('guid');
$offer = get_entity($guid);

if (!$offer || $offer->getSubtype() !== 'event_carpool_offer' || !$offer->canEdit()) {
    return elgg_error_response(elgg_echo('event_carpool:error:cannot_edit'));
}

$seats = (int) get_input('seats');
$pickup_points = get_input('pickup_points');
$notes = get_input('notes');

if ($seats < 1) {
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_seats'));
}

$offer->seats = $seats;
$offer->pickup_points = $pickup_points;
$offer->notes = $notes;

if ($offer->save()) {
    elgg_log("Carpool-offer #{$guid} bijgewerkt", LogLevel::INFO);
    return elgg_ok_response('', elgg_echo('event_carpool:offer_saved'));
}

return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));