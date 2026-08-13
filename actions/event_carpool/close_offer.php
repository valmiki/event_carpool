<?php

elgg_gatekeeper();

$guid = (int) get_input('guid');

// Check of entity bestaat én subtype correct is
$offer = get_entity($guid);
if (!$offer instanceof ElggObject || $offer->getSubtype() !== 'event_carpool_offer') {
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_offer'));
}

// Controleer of de ingelogde gebruiker rechten heeft
if (!$offer->canEdit()) {
    return elgg_error_response(elgg_echo('event_carpool:error:cannot_edit'));
}

// Update status
$offer->status = 'closed';

if ($offer->save()) {
    return elgg_ok_response('', elgg_echo('event_carpool:close:success'));
}

return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));