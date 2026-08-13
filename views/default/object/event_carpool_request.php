<?php
// Wrapper voor carpool-verzoeken

echo elgg_view('event_carpool/carpool_item', [
    'entity' => elgg_extract('entity', $vars),
]);