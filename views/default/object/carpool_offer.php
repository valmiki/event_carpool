<?php
$entity = elgg_extract('entity', $vars);
if (!$entity || $entity->getSubtype() !== 'carpool_offer') {
    return;
}

$owner = $entity->getOwnerEntity();
$seats = $entity->seats;
$pickup_points = $entity->pickup_points;
$notes = $entity->notes;

?>
<div class="elgg-listing-summary">
    <h4><?php echo elgg_echo('event_carpool:offer_by', [$owner->getDisplayName()]); ?></h4>
    <p><?php echo elgg_echo('event_carpool:seats'); ?>: <?php echo htmlspecialchars($seats); ?></p>
    <p><?php echo elgg_echo('event_carpool:pickup_points'); ?>: <?php echo htmlspecialchars($pickup_points); ?></p>
    <?php if ($notes): ?>
        <p><?php echo elgg_echo('event_carpool:notes'); ?>: <?php echo htmlspecialchars($notes); ?></p>
    <?php endif; ?>
</div>