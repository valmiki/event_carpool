<?php
/**
 * Create a carpool request. Any logged-in user who can access the event
 * may request a ride. See add_offer.php for why the save runs inside
 * elgg_call(ELGG_IGNORE_ACCESS, ...).
 */

elgg_gatekeeper();

$event_guid      = (int) get_input('event_guid');
$pickup_location = trim((string) get_input('pickup_location'));
$seats_needed    = (int) get_input('seats_needed');
$notes           = trim((string) get_input('notes'));

$event = get_entity($event_guid);
if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	return elgg_error_response(elgg_echo('event_carpool:error:invalid_event'));
}

if ($seats_needed < 1) {
	return elgg_error_response(elgg_echo('event_carpool:error:invalid_seats_needed'));
}

$owner_guid = elgg_get_logged_in_user_guid();

$request = elgg_call(ELGG_IGNORE_ACCESS, function () use ($event_guid, $owner_guid, $seats_needed, $pickup_location, $notes) {
	$request = new \EventCarpool\Request();
	$request->container_guid  = $event_guid;
	$request->owner_guid      = $owner_guid;
	$request->access_id       = ACCESS_LOGGED_IN;
	$request->seats_needed    = $seats_needed;
	$request->pickup_location = $pickup_location;
	$request->notes           = $notes;

	if (!$request->save()) {
		return null;
	}
	return $request;
});

if (!$request instanceof \EventCarpool\Request) {
	return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
}

return elgg_ok_response('', elgg_echo('event_carpool:request_saved'), $event->getURL());
