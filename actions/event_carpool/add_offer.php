<?php
/**
 * Create a carpool offer. Any logged-in user who can access the event
 * may offer a ride. The offer is attached to the event container; since
 * ordinary users can't write to that container, the save runs inside
 * elgg_call(ELGG_IGNORE_ACCESS, ...) — the same pattern event_manager
 * uses for event registrations. Access to the event itself is already
 * enforced by get_entity(), and elgg_gatekeeper() requires a login.
 */

elgg_gatekeeper();

$event_guid    = (int) get_input('event_guid');
$seats         = (int) get_input('seats');
$pickup_points = trim((string) get_input('pickup_points'));
$notes         = trim((string) get_input('notes'));

$event = get_entity($event_guid);
if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	return elgg_error_response(elgg_echo('event_carpool:error:invalid_event'));
}

if ($seats < 1) {
	return elgg_error_response(elgg_echo('event_carpool:error:invalid_seats'));
}

$owner_guid = elgg_get_logged_in_user_guid();

$offer = elgg_call(ELGG_IGNORE_ACCESS, function () use ($event, $event_guid, $owner_guid, $seats, $pickup_points, $notes) {
	$offer = new \EventCarpool\Offer();
	$offer->container_guid = $event_guid;
	$offer->owner_guid     = $owner_guid;
	$offer->access_id      = ACCESS_LOGGED_IN;
	$offer->seats          = $seats;
	$offer->pickup_points  = $pickup_points;
	$offer->notes          = $notes;

	if (!$offer->save()) {
		return null;
	}

	$event->addRelationship($offer->guid, 'has_carpool_offer');
	return $offer;
});

if (!$offer instanceof \EventCarpool\Offer) {
	return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
}

return elgg_ok_response('', elgg_echo('event_carpool:offer_saved'), $event->getURL());
