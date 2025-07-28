<?php
use Psr\Log\LogLevel;

$guid = (int) get_input('guid');
\elgg_log('Event Carpool: Poging tot verwijderen van aanbieding GUID ' . $guid, LogLevel::NOTICE);

$offer = get_entity($guid);

if (!$offer) {
    \elgg_log('Event Carpool: Geen entity gevonden voor GUID ' . $guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_offer'));
}

if ($offer->getSubtype() !== 'carpool_offer') {
    \elgg_log('Event Carpool: Entity GUID ' . $guid . ' is geen carpool_offer, subtype: ' . $offer->getSubtype(), LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_offer'));
}

if (!$offer->canEdit()) {
    \elgg_log('Event Carpool: Gebruiker kan aanbieding GUID ' . $guid . ' niet bewerken, user GUID: ' . elgg_get_logged_in_user_guid(), LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:cannot_edit'));
}

if ($offer->delete()) {
    \elgg_log('Event Carpool: Aanbieding GUID ' . $guid . ' succesvol verwijderd', LogLevel::NOTICE);
    return elgg_ok_response('', elgg_echo('event_carpool:delete:success'));
}

\elgg_log('Event Carpool: Fout bij verwijderen aanbieding GUID ' . $guid . ', entity type: ' . $offer->type . ', subtype: ' . $offer->getSubtype(), LogLevel::ERROR);
return elgg_error_response(elgg_echo('event_carpool:error:delete_failed'));