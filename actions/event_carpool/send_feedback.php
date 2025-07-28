<?php
use Psr\Log\LogLevel;

$offer_guid = (int) get_input('offer_guid');
$owner_guid = (int) get_input('owner_guid');
$message = get_input('message');
$sender_guid = elgg_get_logged_in_user_guid();

if (!$offer_guid || !$owner_guid || !$sender_guid || empty($message)) {
    \elgg_log('Event Carpool: Ongeldige feedback-invoer', LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_input'));
}

$offer = get_entity($offer_guid);
if (!$offer || $offer->getSubtype() !== 'carpool_offer' || $offer->owner_guid !== $owner_guid) {
    \elgg_log('Event Carpool: Ongeldige aanbieding, GUID: ' . $offer_guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_offer'));
}

$owner = get_entity($owner_guid);
if (!$owner || !$owner instanceof \ElggUser) {
    \elgg_log('Event Carpool: Ongeldige eigenaar, GUID: ' . $owner_guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_owner'));
}

$result = elgg_send_message($sender_guid, $owner_guid, elgg_echo('event_carpool:feedback:subject', [$offer_guid]), $message);
if (!$result) {
    \elgg_log('Event Carpool: Feedback verzenden mislukt, GUID: ' . $offer_guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:feedback:send_failed'));
}

\elgg_log('Event Carpool: Feedback verzonden, GUID: ' . $offer_guid, LogLevel::NOTICE);
return elgg_ok_response('', elgg_echo('event_carpool:feedback:sent'), null);