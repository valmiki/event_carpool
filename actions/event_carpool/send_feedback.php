<?php
/**
 * Sends a message from the current user to the owner of a carpool offer
 * OR request ("respond" / contact the driver or requester).
 */

use Psr\Log\LogLevel;

elgg_gatekeeper();

$entity_guid = (int) get_input('entity_guid');
$message     = trim((string) get_input('message'));
$sender      = elgg_get_logged_in_user_entity();

if (!$entity_guid || !$sender || $message === '') {
	return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_input'));
}

$entity = get_entity($entity_guid);
$valid  = ['event_carpool_offer', 'event_carpool_request'];
if (!$entity instanceof \ElggObject || !in_array($entity->getSubtype(), $valid, true)) {
	return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_offer'));
}

$recipient = $entity->getOwnerEntity();
if (!$recipient instanceof \ElggUser) {
	return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_owner'));
}

if ($recipient->guid === $sender->guid) {
	return elgg_error_response(elgg_echo('event_carpool:feedback:invalid_input'));
}

$subject = elgg_echo('event_carpool:feedback:subject', [$sender->getDisplayName()]);
$body = elgg_echo('event_carpool:feedback:body', [
	$recipient->getDisplayName(),
	$sender->getDisplayName(),
	$message,
]);

$email = \Elgg\Email::factory([
	'from'    => $sender,
	'to'      => $recipient,
	'subject' => $subject,
	'body'    => $body,
]);

if (!elgg_send_email($email)) {
	elgg_log("Event Carpool: contact email failed for entity #{$entity_guid}", LogLevel::ERROR);
	return elgg_error_response(elgg_echo('event_carpool:feedback:send_failed'));
}

return elgg_ok_response('', elgg_echo('event_carpool:feedback:sent'));
