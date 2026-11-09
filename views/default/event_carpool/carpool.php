<?php
/**
 * Carpool block, appended to event_manager/event/view (event_manager <= 21.1)
 * or to event_manager/event/view/location (event_manager >= 21.2).
 *
 * The event is taken from $vars['entity'] (the base view is rendered
 * with the event in scope). Page owner is only a fallback, because
 * event_manager 21's event resource does not set the event as page
 * owner.
 */

$event = elgg_extract('entity', $vars);

if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	$event = elgg_get_page_owner_entity();
}

if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	return;
}

$event_guid = (int) $event->guid;
if ($event_guid < 1) {
	return;
}

// Online events (and any event without a physical venue/location) don't
// need carpooling. event_manager stores the physical location in the
// `location` and `venue` metadata; if both are empty, hide the block.
$location = trim((string) ($event->location ?? ''));
$venue    = trim((string) ($event->venue ?? ''));
if ($location === '' && $venue === '') {
	return;
}

$view_params = ['event_guid' => $event_guid];

echo elgg_format_element('hr');
echo elgg_format_element('div', ['class' => 'event-carpool'], implode('', [
	elgg_view('event_carpool/add_offer', $view_params),
	elgg_view('event_carpool/offers', $view_params),
	elgg_view('event_carpool/add_request', $view_params),
	elgg_view('event_carpool/requests', $view_params),
]));
