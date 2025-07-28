<?php
return [
    'plugin' => [
        'name' => 'Event Carpool',
        'version' => '1.0.0',
        'dependencies' => [
            'event_manager' => [
                'must_be_active' => true,
            ],
        ],
    ],
    'javascript' => [
        'event_carpool/offers' => 'mod/event_carpool/views/default/js/event_carpool/offers.mjs',
    ],
    'bootstrap' => \EventCarpool\Bootstrap::class,
    'hooks' => [
        'view_vars' => [
            'event_manager/event/view/location' => [
                'EventCarpool\Bootstrap::prepareCarpoolVars' => [],
            ],
        ],
    ],
    'actions' => [
        'event_carpool/add_offer' => [
            'access' => 'logged_in',
        ],
        'event_carpool/add_request' => [
            'access' => 'logged_in',
        ],
        'event_carpool/close_offer' => [
            'access' => 'logged_in',
        ],
        'event_carpool/delete_offer' => [
            'access' => 'logged_in',
        ],
    ],
    'view_extensions' => [
        'event_manager/event/view/location' => [
            'event_carpool/offers' => ['priority' => 500],
            'event_carpool/requests' => ['priority' => 501],
        ],
    ],
];