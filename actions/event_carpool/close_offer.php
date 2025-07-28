<?php
use Psr\Log\LogLevel;

$guid = (int) get_input('guid');
\elgg_log('Event Carpool: Poging tot sluiten van aanbieding GUID ' . $guid, LogLevel::NOTICE);

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

$offer->status = 'closed';
if ($offer->save()) {
    \elgg_log('Event Carpool: Aanbieding GUID ' . $guid . ' succesvol gesloten', LogLevel::NOTICE);
    return elgg_ok_response('', elgg_echo('event_carpool:close:success'));
}

\elgg_log('Event Carpool: Fout bij sluiten aanbieding GUID ' . $guid, LogLevel::ERROR);
return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));