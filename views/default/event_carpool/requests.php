<?php
use Psr\Log\LogLevel;

$event_guid = (int) elgg_extract('event_guid', $vars);
if (!$event_guid) {
    elgg_log('Event Carpool: Geen event_guid voor verzoeken', LogLevel::ERROR);
    return;
}

$event = get_entity($event_guid);
if (!$event || $event->getSubtype() !== 'event') {
    elgg_log('Event Carpool: Ongeldig of geen event-entity voor verzoeken (GUID: ' . $event_guid . ')', LogLevel::ERROR);
    return;
}

elgg_log('Event Carpool: Rendering verzoeken voor evenement GUID ' . $event_guid, LogLevel::INFO);

// Fetch requests related to the event
$requests = elgg_get_entities([
    'type' => 'object',
    'subtype' => 'carpool_request',
    'container_guid' => $event_guid,
    'limit' => 0,
]);

if (empty($requests)) {
    elgg_log('Event Carpool: Geen verzoeken gevonden voor evenement GUID ' . $event_guid, LogLevel::INFO);
    echo elgg_echo('event_carpool:no_requests');
    return;
}

// Display requests
echo '<ul class="elgg-list">';
foreach ($requests as $request) {
    $owner = $request->getOwnerEntity();
    $title = $owner ? elgg_echo('event_carpool:request_by', [$owner->getDisplayName()]) : elgg_echo('event_carpool:request');
    $edit_link = $request->canEdit() ? elgg_view('output/url', [
        'href' => "action/event_carpool/edit_request?guid={$request->guid}",
        'text' => elgg_echo('edit'),
        'is_action' => true,
        'class' => 'elgg-action-request',
        'data-guid' => $request->guid,
    ]) : '';
    echo elgg_format_element('li', ['class' => 'elgg-item'], elgg_view('output/longtext', [
        'value' => $title . ': ' . $request->description . ' ' . $edit_link,
    ]));
}
echo '</ul>';