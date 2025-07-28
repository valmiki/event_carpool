<?php
$entity = elgg_extract('entity', $vars);
if (!$entity || $entity->getSubtype() !== 'event') {
    \elgg_log('Event Carpool: Invalid or no entity in event_manager/event/view', 'NOTICE');
    return;
}

// Render the original event content
echo \elgg_view('event_manager/event/view_orig', $vars);

// Append carpool content
$carpool_content = elgg_extract('carpool_content', $vars, '');
if ($carpool_content) {
    echo $carpool_content;
} else {
    \elgg_log('Event Carpool: No carpool_content provided in event_manager/event/view', 'NOTICE');
}