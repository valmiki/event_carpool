<?php
$offer_guid = elgg_extract('offer_guid', $vars);
$owner_guid = elgg_extract('owner_guid', $vars);
?>

<div class="elgg-field">
    <label><?php echo elgg_echo('event_carpool:feedback:label'); ?></label>
    <?php
    echo elgg_view('input/textarea', [
        'name' => 'message',
        'required' => true,
    ]);
    ?>
</div>

<?php
echo elgg_view('input/hidden', ['name' => 'offer_guid', 'value' => $offer_guid]);
echo elgg_view('input/hidden', ['name' => 'owner_guid', 'value' => $owner_guid]);
echo elgg_view('input/submit', [
    'value' => elgg_echo('event_carpool:feedback:submit'),
    'class' => 'elgg-button elgg-button-submit',
]);