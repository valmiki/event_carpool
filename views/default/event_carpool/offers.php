<?php
// views/default/event_carpool/offers.php
//
// Renders the carpool OFFERS list. Sets item_view explicitly to
// event_carpool/carpool_item (mirroring requests.php) so it never falls
// back to the default entity summary — that fallback is what showed the
// bare "EventCarpool\Offer" class name instead of the styled card.
//
// offers.mjs drives the toggle + close/delete for both offers AND
// requests, and send_feedback.mjs handles the "contact the driver" form.

$event_guid = (int) elgg_extract('event_guid', $vars, 0);
if ($event_guid < 1) {
	return;
}

$event = get_entity($event_guid);
if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	return;
}

elgg_import_esm('js/offers');
elgg_import_esm('js/send_feedback');

$list = elgg_list_entities([
	'type'                 => 'object',
	'subtype'              => 'event_carpool_offer',
	'relationship'         => 'has_carpool_offer',
	'relationship_guid'    => $event_guid,
	'inverse_relationship' => false,
	'limit'                => 0,
	'pagination'           => false,
	'item_view'            => 'event_carpool/carpool_item',
	'no_results'           => elgg_echo('event_carpool:no_offers'),
]);

echo elgg_view_module('info', elgg_echo('event_carpool:offers'), $list, [
	'class' => 'event-carpool-offers',
]);
