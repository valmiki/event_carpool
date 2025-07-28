<?php
use Psr\Log\LogLevel;
use Elgg\Database\Select;

$event_guid = (int) get_input('event_guid');
$seats = (int) get_input('seats');
$pickup_points = get_input('pickup_points');
$notes = elgg_strip_tags(get_input('notes')); // Grondige HTML-opschoning

\elgg_log('Event Carpool: Rauwe invoer add_offer: ' . print_r($_POST, true), LogLevel::NOTICE);
\elgg_log('Event Carpool: Verwerkte invoer add_offer: ' . print_r([
    'event_guid' => $event_guid,
    'seats' => $seats,
    'pickup_points' => $pickup_points,
    'notes' => $notes,
    'user_guid' => elgg_get_logged_in_user_guid(),
], true), LogLevel::NOTICE);

if (!$event_guid || $seats < 1 || empty($pickup_points)) {
    \elgg_log('Event Carpool: Ongeldige invoer voor add_offer: ' . print_r([
        'event_guid' => $event_guid,
        'seats' => $seats,
        'pickup_points' => $pickup_points,
    ], true), LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_input'));
}

$event = get_entity($event_guid);
if (!$event || $event->getSubtype() !== 'event') {
    \elgg_log('Event Carpool: Ongeldig evenement voor add_offer, GUID: ' . $event_guid, LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:error:invalid_event'));
}

$user_guid = elgg_get_logged_in_user_guid();
if (!$user_guid) {
    \elgg_log('Event Carpool: Geen ingelogde gebruiker voor add_offer', LogLevel::ERROR);
    return elgg_error_response(elgg_echo('event_carpool:login_required'));
}

try {
    $offer = new \ElggObject();
    $offer->setSubtype('carpool_offer');
    $offer->owner_guid = $user_guid;
    $offer->container_guid = $event_guid;
    $offer->access_id = $event->access_id;
    $offer->seats = $seats;
    $offer->pickup_points = $pickup_points;
    $offer->notes = $notes;

    \elgg_log('Event Carpool: Poging om carpool-aanbieding op te slaan voor GUID ' . $event_guid . ', user GUID ' . $user_guid . ', access_id: ' . $offer->access_id, LogLevel::NOTICE);

    // Sla entiteit op
    $save_result = $offer->save();
    \elgg_log('Event Carpool: save() resultaat voor aanbieding: ' . ($save_result ? 'succes' : 'mislukt'), LogLevel::NOTICE);
    if (!$save_result) {
        \elgg_log('Event Carpool: Mislukt om carpool-aanbieding op te slaan voor GUID ' . $event_guid . ': ' . print_r($offer->getError() ?? 'Geen specifieke foutmelding', true), LogLevel::ERROR);
        return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
    }

    \elgg_log('Event Carpool: Aanbieding opgeslagen, GUID: ' . $offer->guid, LogLevel::NOTICE);

    // Controleer of entiteit in database bestaat
    $select = Select::fromTable('entities');
    $select->select('guid')->where($select->compare('guid', '=', $offer->guid, ELGG_VALUE_GUID));
    $exists = elgg()->db->getDataRow($select);
    if (!$exists) {
        \elgg_log('Event Carpool: Entiteit niet gevonden in elgg_entities na opslaan, GUID: ' . $offer->guid, LogLevel::ERROR);
        $offer->delete();
        return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
    }

    \elgg_log('Event Carpool: Entiteit bevestigd in database, GUID: ' . $offer->guid, LogLevel::NOTICE);
    \elgg_log('Event Carpool: Poging om relatie toe te voegen voor offer GUID ' . $offer->guid . ' met event GUID ' . $event_guid, LogLevel::NOTICE);

    // Controleer op duplicaatrelatie
    $relationship = new \ElggRelationship();
    $relationship->guid_one = $offer->guid;
    $relationship->relationship = 'for_event';
    $relationship->guid_two = $event_guid;

    if (elgg()->relationships->check($offer->guid, 'for_event', $event_guid)) {
        \elgg_log('Event Carpool: Relatie bestaat al voor offer GUID ' . $offer->guid . ' en event GUID ' . $event_guid, LogLevel::NOTICE);
    } else {
        $event_result = elgg_trigger_event_results('create', 'relationship', $relationship, true);
        \elgg_log('Event Carpool: create relationship event resultaat: ' . ($event_result ? 'toegestaan' : 'geblokkeerd'), LogLevel::NOTICE);
        if (!$event_result) {
            \elgg_log('Event Carpool: Relatie geblokkeerd door create event voor offer GUID ' . $offer->guid, LogLevel::ERROR);
            $offer->delete();
            return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
        }
        $result = elgg()->relationships->add($relationship, true); // Vraag relatie-ID terug
        if (!$result) {
            \elgg_log('Event Carpool: Mislukt om relatie toe te voegen voor offer GUID ' . $offer->guid . ': Onbekende fout', LogLevel::ERROR);
            // Controleer of de relatie in de database staat
            $rel_select = Select::fromTable('entity_relationships');
            $rel_select->select('id')
                ->where($rel_select->compare('guid_one', '=', $offer->guid, ELGG_VALUE_GUID))
                ->andWhere($rel_select->compare('relationship', '=', 'for_event', ELGG_VALUE_STRING))
                ->andWhere($rel_select->compare('guid_two', '=', $event_guid, ELGG_VALUE_GUID));
            $rel_exists = elgg()->db->getDataRow($rel_select);
            \elgg_log('Event Carpool: Relatie check na add: ' . ($rel_exists ? 'bestaat (ID: ' . $rel_exists->id . ')' : 'bestaat niet'), LogLevel::NOTICE);
            $offer->delete();
            return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
        }
        \elgg_log('Event Carpool: Relatie succesvol toegevoegd voor offer GUID ' . $offer->guid . ', relatie ID: ' . $result, LogLevel::NOTICE);
    }

    \elgg_log('Event Carpool: Carpool-aanbieding succesvol opgeslagen voor evenement GUID ' . $event_guid . ', offer GUID ' . $offer->guid, LogLevel::NOTICE);
    return elgg_ok_response('', elgg_echo('event_carpool:offer_added'), $event->getURL());
} catch (Exception $e) {
    \elgg_log('Event Carpool: Uitzondering in add_offer: ' . $e->getMessage() . ', trace: ' . $e->getTraceAsString(), LogLevel::ERROR);
    if (isset($offer) && $offer->guid) {
        $offer->delete();
    }
    return elgg_error_response(elgg_echo('event_carpool:error:save_failed'));
}