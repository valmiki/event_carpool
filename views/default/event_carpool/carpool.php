<?php
use Psr\Log\LogLevel;

// Try to get event_guid from URL, page owner, $vars, or route
$event_guid = (int) get_input('guid', 0);
$entity = elgg_extract('entity', $vars);
if ($entity instanceof \ElggEntity && $entity->getSubtype() === 'event') {
    $event_guid = (int) $entity->guid;
} elseif (elgg_extract('event_guid', $vars)) {
    $event_guid = (int) elgg_extract('event_guid', $vars);
} elseif ($page_owner = elgg_get_page_owner_entity()) {
    if ($page_owner instanceof \ElggEntity && $page_owner->getSubtype() === 'event') {
        $event_guid = (int) $page_owner->guid;
    }
} elseif ($route = elgg_get_current_route()) {
    if ($route->getName() === 'view:object:event' && $route->getParameter('guid')) {
        $event_guid = (int) $route->getParameter('guid');
    }
}

// Debug input
elgg_log('Event Carpool: URL: ' . $_SERVER['REQUEST_URI'] . ', get_input("guid"): ' . get_input('guid') . ', page_owner_guid: ' . ($page_owner ? $page_owner->guid : 'none') . ', route_guid: ' . ($route ? $route->getParameter('guid', 'none') : 'none') . ', vars: ' . print_r($vars, true), LogLevel::DEBUG);

if (!$event_guid) {
    elgg_log('Event Carpool: Geen event_guid opgegeven', LogLevel::ERROR);
    return;
}

$event = get_entity($event_guid);
if (!$event || $event->getSubtype() !== 'event') {
    elgg_log('Event Carpool: Ongeldig evenement voor GUID ' . $event_guid, LogLevel::ERROR);
    return;
}

elgg_log('Event Carpool: Rendering carpool-sectie voor evenement GUID ' . $event_guid, LogLevel::INFO);

echo elgg_view('event_carpool/add_offer', ['event_guid' => $event_guid]);
echo elgg_view('event_carpool/offers', ['event_guid' => $event_guid]);
echo elgg_view('event_carpool/add_request', ['event_guid' => $event_guid]);
echo elgg_view('event_carpool/requests', ['event_guid' => $event_guid]);