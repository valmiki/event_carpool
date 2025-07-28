<?php
$entity = elgg_extract('entity', $vars);
if (!$entity || $entity->getSubtype() !== 'carpool_request') {
    return;
}

$owner = $entity->getOwnerEntity();
$seats_needed = $entity->seats_needed;
$pickup_location = $entity->pickup_location;
$notes = $entity->notes;

?>
<div class="elgg-listing-summary">
    <h4><?php echo elgg_echo('event_carpool:request_by', [$owner->getDisplayName()]); ?></h4>
    <p><?php echo elgg_echo('event_carpool:seats_needed'); ?>: <?php echo htmlspecialchars($seats_needed); ?></p>
    <p><?php echo elgg_echo('event_carpool:pickup_location'); ?>: <?php echo htmlspecialchars($pickup_location); ?></p>
    <?php if ($notes): ?>
        <p><?php echo elgg_echo('event_carpool:notes'); ?>: <?php echo htmlspecialchars($notes); ?></p>
    <?php endif; ?>
</div>