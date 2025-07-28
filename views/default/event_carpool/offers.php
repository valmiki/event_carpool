<?php
use Psr\Log\LogLevel;

$event_guid = (int) elgg_extract('event_guid', $vars);
if (!$event_guid) {
    elgg_log('Event Carpool: Geen event_guid voor aanbiedingen', LogLevel::ERROR);
    return;
}

$event = get_entity($event_guid);
if (!$event || $event->getSubtype() !== 'event') {
    elgg_log('Event Carpool: Ongeldig of geen event-entity voor aanbiedingen (GUID: ' . $event_guid . ')', LogLevel::ERROR);
    return;
}

elgg_log('Event Carpool: Ophalen aanbiedingen voor event GUID ' . $event_guid, LogLevel::INFO);

// Load JavaScript module
elgg_import_esm('event_carpool/offers');

// Fetch offers
$offers = elgg_get_entities([
    'type' => 'object',
    'subtype' => 'carpool_offer',
    'container_guid' => $event_guid,
    'limit' => 0,
]);

elgg_log('Event Carpool: Aantal opgehaalde aanbiedingen voor GUID ' . $event_guid . ': ' . count($offers), LogLevel::INFO);

if (empty($offers)) {
    echo elgg_echo('event_carpool:no_offers');
    return;
}

// Display offers
echo '<ul class="elgg-list">';
foreach ($offers as $offer) {
    elgg_log('Event Carpool: Aanbieding GUID ' . $offer->guid . ', owner GUID ' . $offer->owner_guid . ', canEdit: ' . var_export($offer->canEdit(), true), LogLevel::INFO);
    $owner = $offer->getOwnerEntity();
    $title = $owner ? elgg_echo('event_carpool:offer_by', [$owner->getDisplayName()]) : elgg_echo('event_carpool:offer');
    $edit_link = $offer->canEdit() ? elgg_view('output/url', [
        'href' => "action/event_carpool/edit_offer?guid={$offer->guid}",
        'text' => elgg_echo('edit'),
        'is_action' => true,
        'class' => 'elgg-action-offer',
        'data-guid' => $offer->guid,
    ]) : '';
    echo elgg_format_element('li', ['class' => 'elgg-item'], elgg_view('output/longtext', [
        'value' => $title . ': ' . $offer->description . ' ' . $edit_link,
    ]));
}
echo '</ul>';