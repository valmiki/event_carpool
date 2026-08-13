<?php
// views/default/object/event_carpool_offer.php

elgg_log('👀 object/event_carpool_offer.php wordt uitgevoerd', \Psr\Log\LogLevel::NOTICE);

$entity = $vars['entity'] ?? null;
if (!$entity instanceof \ElggEntity) {
	elgg_log("⚠️ object/event_carpool_offer.php kreeg geen geldige entity", \Psr\Log\LogLevel::NOTICE);
	return;
}

echo elgg_view('event_carpool/carpool_item', ['entity' => $entity]);