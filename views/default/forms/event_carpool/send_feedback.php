<?php

$entity_guid = (int) elgg_extract('entity_guid', $vars);

echo elgg_view_field([
	'#type'  => 'hidden',
	'name'   => 'entity_guid',
	'value'  => $entity_guid,
]);

echo elgg_view_field([
	'#type'     => 'plaintext',
	'#label'    => elgg_echo('event_carpool:contact:label'),
	'name'      => 'message',
	'required'  => true,
	'rows'      => 3,
]);

echo elgg_view('input/submit', [
	'text'  => elgg_echo('event_carpool:submit_feedback'),
	'value' => elgg_echo('event_carpool:submit_feedback'),
]);
