<?php
/**
 * Fixes vs. the original:
 *  - Actions registered ONCE here (Bootstrap no longer also registers
 *    them), matching the action files on disk incl. send_feedback.
 *  - Dead `javascript` block removed (it pointed at non-existent paths).
 *  - `entities` registration added: Elgg 7 made ElggObject abstract, so
 *    each object subtype needs a concrete class. This maps the carpool
 *    subtypes to EventCarpool\Offer / EventCarpool\Request so they can
 *    be both created and loaded.
 */
return [
    'plugin' => [
        'name' => 'Event Carpool',
        'version' => '2.1.1',
        'dependencies' => [
            'event_manager' => [
                'must_be_active' => true,
            ],
        ],
    ],

    'bootstrap' => \EventCarpool\Bootstrap::class,

    'entities' => [
        [
            'type'    => 'object',
            'subtype' => 'event_carpool_offer',
            'class'   => \EventCarpool\Offer::class,
        ],
        [
            'type'    => 'object',
            'subtype' => 'event_carpool_request',
            'class'   => \EventCarpool\Request::class,
        ],
    ],

    'actions' => [
        'event_carpool/add_offer'     => ['access' => 'logged_in'],
        'event_carpool/edit_offer'    => ['access' => 'logged_in'],
        'event_carpool/close_offer'   => ['access' => 'logged_in'],
        'event_carpool/delete_offer'  => ['access' => 'logged_in'],
        'event_carpool/add_request'   => ['access' => 'logged_in'],
        'event_carpool/edit_request'  => ['access' => 'logged_in'],
        'event_carpool/close_request' => ['access' => 'logged_in'],
        'event_carpool/delete_request' => ['access' => 'logged_in'],
        'event_carpool/send_feedback' => ['access' => 'logged_in'],
    ],
];
