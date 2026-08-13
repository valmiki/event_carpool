<?php

elgg_gatekeeper();

$guid = (int) get_input('guid');

$offer = get_entity($guid);
if (!$offer instanceof ElggObject || $offer->getSubtype() !== 'event_carpool_offer') {
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_offer'));
}

if (!$offer->canEdit()) {
    return elgg_error_response(elgg_echo('event_carpool:error:cannot_edit'));
}

if ($offer->delete()) {
    return elgg_ok_response('', elgg_echo('event_carpool:delete:success'));
}

return elgg_error_response(elgg_echo('event_carpool:error:delete_failed'));