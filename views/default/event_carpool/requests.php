<?php

use Psr\Log\LogLevel;

$event_guid = (int) elgg_extract('event_guid', $vars);
if (!$event_guid) {
	elgg_log("Event Carpool: ⚠️ requests.php received NO event_guid", LogLevel::WARNING);
	return;
}

$event = get_entity($event_guid);
if (!$event instanceof \ElggEntity || $event->getSubtype() !== 'event') {
	elgg_log("Event Carpool: Invalid event entity for GUID {$event_guid}", LogLevel::ERROR);
	return;
}

$list = elgg_list_entities([
	'type'        => 'object',
	'subtype'     => 'event_carpool_request',
	'container_guid' => $event_guid,
	'limit'       => 0,
	'pagination'  => false,
	'item_view'   => 'event_carpool/carpool_item',
	'no_results'  => elgg_echo('event_carpool:no_requests'),
]);

echo elgg_view_module('info', elgg_echo('event_carpool:requests'), $list, [
	'class' => 'event-carpool-requests',
]);