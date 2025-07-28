<?php
namespace EventCarpool;

use Elgg\DefaultPluginBootstrap;
use Elgg\Event;
use Psr\Log\LogLevel;

class Bootstrap extends DefaultPluginBootstrap {

    public function init() {
        \elgg_import_esm('elgg');
        \elgg_import_esm('jquery');
        \elgg_import_esm('event_carpool/offers');
        \elgg_extend_view('elgg.css', 'css/event_carpool.css');

        \elgg_register_event_handler('view_vars', 'event_manager/event/view', [$this, 'setEventContext']);
        \elgg_extend_view('event_manager/event/view', 'event_carpool/carpool', 500); // Voeg carpool-sectie toe
        
        elgg_register_action('event_carpool/add_offer', elgg_get_plugins_path() . 'event_carpool/actions/event_carpool/add_offer.php', 'logged_in');
        elgg_register_action('event_carpool/edit_offer', elgg_get_plugins_path() . 'event_carpool/actions/event_carpool/edit_offer.php', 'logged_in');
        elgg_register_action('event_carpool/add_request', elgg_get_plugins_path() . 'event_carpool/actions/event_carpool/add_request.php', 'logged_in');
        elgg_register_action('event_carpool/edit_request', elgg_get_plugins_path() . 'event_carpool/actions/event_carpool/edit_request.php', 'logged_in');

        \elgg_log('Event Carpool: Bootstrap init called', LogLevel::INFO);
    }

    public function setEventContext(Event $event) {
        $vars = $event->getValue();
        $entity = elgg_extract('entity', $vars);

        if ($entity && $entity->getSubtype() === 'event') {
            \elgg_push_context('event');
            \elgg_log('Event Carpool: Context ingesteld op "event" voor GUID ' . $entity->guid, LogLevel::INFO);
        }
    }
}