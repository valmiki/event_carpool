<?php

elgg_gatekeeper();

$guid = (int) get_input('guid');

$request = get_entity($guid);
if (!$request instanceof \ElggObject || $request->getSubtype() !== 'event_carpool_request') {
	return elgg_error_response(elgg_echo('event_carpool:error:invalid_entity'));
}

if (!$request->canEdit()) {
	return elgg_error_response(elgg_echo('event_carpool:error:cannot_edit'));
}

$request->status = 'closed';

if ($request->save()) {
	return elgg_ok_response('', elgg_echo('event_carpool:close:success'));
}

return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
