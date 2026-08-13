<?php
/**
 * Dutch translations for Event Carpool.
 *
 * Note on apostrophes: Dutch words like "auto's" contain an apostrophe.
 * Inside a SINGLE-quoted PHP string that apostrophe would terminate the
 * string early and cause a parse error, so any value containing one is
 * written with DOUBLE quotes (or the apostrophe is escaped as \').
 */
return [
    // General strings
    'event_carpool:offers'          => 'Carpool-aanbiedingen',
    'event_carpool:no_offers'       => 'Geen carpool-aanbiedingen gevonden',
    'event_carpool:requests'        => 'Carpool-verzoeken',
    'event_carpool:no_requests'     => 'Geen carpool-verzoeken gevonden',
    'event_carpool:offer_by'        => 'Aangeboden door %s',
    'event_carpool:request_by'      => 'Gevraagd door %s',
    'event_carpool:seats'           => 'Aantal plaatsen',
    'event_carpool:pickup_points'   => 'Opstappunten',
    'event_carpool:notes'           => 'Opmerkingen',
    'event_carpool:seats_needed'    => 'Aantal benodigde plaatsen',
    'event_carpool:pickup_location' => 'Ophaallocatie',
    'event_carpool:status_open'     => 'Open',
    'event_carpool:status_closed'   => 'Gesloten',
    'event_carpool:offer_saved'     => 'Carpool-aanbod opgeslagen.',
    'event_carpool:request_saved'   => 'Carpool-verzoek opgeslagen.',
    'event_carpool:offers:empty'    => 'Nog geen carpool-aanbiedingen.',
    'event_carpool:requests:empty'  => 'Nog geen carpool-verzoeken.',

    // Actions and forms
    'event_carpool:add_offer'        => 'Carpool aanbieden',
    'event_carpool:add_request'      => 'Rit aanvragen',
    'event_carpool:submit_request'   => 'Verzoek indienen',
    'event_carpool:submit_feedback'  => 'Bericht versturen',
    'event_carpool:close_offer'      => 'Sluiten',
    'event_carpool:delete_offer'     => 'Verwijderen',
    'event_carpool:close:success'    => 'Aanbod is gesloten',
    'event_carpool:delete:success'   => 'Aanbod is verwijderd',

    // Interface elements
    'event_carpool:show_details'  => 'Details tonen',
    'event_carpool:hide_details'  => 'Details verbergen',
    'event_carpool:button:close'  => 'Sluiten',
    'event_carpool:button:delete' => 'Verwijderen',
    'deleteconfirm'               => 'Weet je zeker dat je dit wilt verwijderen?',

    'event_carpool:contact:heading'        => 'Reageren',
    'event_carpool:contact:label'          => 'Je bericht',

    // Feedback ("contact the driver")
    'event_carpool:feedback:label'         => 'Bericht aan de chauffeur',
    'event_carpool:feedback:invalid_input' => 'Voer een bericht in.',
    'event_carpool:feedback:invalid_offer' => 'Ongeldig carpool-aanbod.',
    'event_carpool:feedback:invalid_owner' => 'Dit aanbod heeft geen geldige eigenaar om te contacteren.',
    'event_carpool:feedback:sent'          => 'Je bericht is naar de chauffeur verstuurd.',
    'event_carpool:feedback:send_failed'   => 'Je bericht kon niet worden verstuurd. Probeer het opnieuw.',
    'event_carpool:feedback:subject'       => 'Nieuw carpool-bericht van %s',
    'event_carpool:feedback:body'          => "Hallo %s,\n\n%s schreef over je carpool-aanbod:\n\n%s",

    // Error messages
    'event_carpool:error:invalid_event'        => 'Ongeldig evenement',
    'event_carpool:error:invalid_input'        => 'Ongeldige invoer',
    'event_carpool:error:invalid_seats'        => 'Geef minstens één plaats op.',
    'event_carpool:error:invalid_seats_needed' => 'Geef het aantal benodigde plaatsen op.',
    'event_carpool:error:invalid_offer'        => 'Ongeldig aanbod',
    'event_carpool:error:cannot_edit'          => 'Je mag dit item niet bewerken.',
    'event_carpool:error:invalid_entity'       => 'Ongeldig aanbod of verzoek',
    'event_carpool:error:permission_denied'    => 'Geen toestemming voor deze actie',
    'event_carpool:error:save_failed'          => 'Je carpool-gegevens konden niet worden opgeslagen. Probeer het opnieuw.',
    'event_carpool:error:delete_failed'        => 'Het carpool-aanbod kon niet worden verwijderd.',
    'event_carpool:login_required'             => 'Je moet ingelogd zijn om deze actie uit te voeren',
];
