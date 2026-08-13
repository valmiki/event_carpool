<?php
use Psr\Log\LogLevel;

elgg_gatekeeper();

$guid = (int) get_input('guid');
$request = get_entity($guid);

if (!$request || $request->getSubtype() !== 'event_carpool_request' || !$request->canEdit()) {
    return elgg_error_response(elgg_echo('event_carpool:error:cannot_edit'));
}

$seats_needed = (int) get_input('seats_needed');
$pickup_location = get_input('pickup_location');
$notes = get_input('notes');

if ($seats_needed < 1) {
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_seats_needed'));
}

$request->seats_needed = $seats_needed;
$request->pickup_location = $pickup_location;
$request->notes = $notes;

if ($request->save()) {
    elgg_log("Carpool-request #{$guid} bijgewerkt", LogLevel::INFO);
    return elgg_ok_response('', elgg_echo('event_carpool:request_saved'));
}

return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));