<?php
return [
    // General strings
    'event_carpool:offers'          => 'Carpool Offers',
    'event_carpool:no_offers'       => 'No carpool offers found',
    'event_carpool:requests'        => 'Carpool Requests',
    'event_carpool:no_requests'     => 'No carpool requests found',
    'event_carpool:offer_by'        => 'Offered by %s',
    'event_carpool:request_by'      => 'Requested by %s',
    'event_carpool:seats'           => 'Number of seats',
    'event_carpool:pickup_points'   => 'Pickup points',
    'event_carpool:notes'           => 'Notes',
    'event_carpool:seats_needed'    => 'Number of seats needed',
    'event_carpool:pickup_location' => 'Pickup location',
    'event_carpool:status_open'     => 'Open',
    'event_carpool:status_closed'   => 'Closed',
    'event_carpool:offer_saved'     => 'Carpool offer saved.',
    'event_carpool:request_saved'   => 'Carpool request saved.',
    'event_carpool:offers:empty'    => 'No carpool offers yet.',
    'event_carpool:requests:empty'  => 'No carpool requests yet.',

    // Actions and forms
    'event_carpool:add_offer'       => 'Offer carpool',
    'event_carpool:add_request'     => 'Request Ride',
    'event_carpool:submit_request'  => 'Submit request',
    'event_carpool:submit_feedback' => 'Send message',
    'event_carpool:close_offer'     => 'Close',
    'event_carpool:delete_offer'    => 'Delete',
    'event_carpool:close:success'   => 'Offer has been closed',
    'event_carpool:delete:success'  => 'Offer has been deleted',

    // Interface elements
    'event_carpool:show_details'  => 'Show Details',
    'event_carpool:hide_details'  => 'Hide Details',
    'event_carpool:button:close'  => 'Close',
    'event_carpool:button:delete' => 'Delete',
    'deleteconfirm'               => 'Are you sure you want to delete this?',

    // Respond / contact
    'event_carpool:contact:heading'        => 'Respond',
    'event_carpool:contact:label'          => 'Your message',

    // Feedback ("contact the driver")
    'event_carpool:feedback:label'         => 'Message to the driver',
    'event_carpool:feedback:invalid_input' => 'Please enter a message.',
    'event_carpool:feedback:invalid_offer' => 'Invalid carpool offer.',
    'event_carpool:feedback:invalid_owner' => 'This offer has no valid owner to contact.',
    'event_carpool:feedback:sent'          => 'Your message has been sent to the driver.',
    'event_carpool:feedback:send_failed'   => 'Your message could not be sent. Please try again.',
    'event_carpool:feedback:subject'       => 'New carpool message from %s',
    'event_carpool:feedback:body'          => "Hi %s,\n\n%s wrote about your carpool offer:\n\n%s",

    // Error messages
    'event_carpool:error:invalid_event'        => 'Invalid event',
    'event_carpool:error:invalid_input'        => 'Invalid input',
    'event_carpool:error:invalid_seats'        => 'Please enter at least one seat.',
    'event_carpool:error:invalid_seats_needed' => 'Please enter the number of seats needed.',
    'event_carpool:error:invalid_offer'        => 'Invalid offer',
    'event_carpool:error:invalid_entity'       => 'Invalid offer or request',
    'event_carpool:error:cannot_edit'          => 'You are not allowed to edit this item.',
    'event_carpool:error:permission_denied'    => 'No permission to perform this action',
    'event_carpool:error:save_failed'          => 'Could not save your carpool data. Please try again.',
    'event_carpool:error:delete_failed'        => 'Could not delete the carpool offer.',
    'event_carpool:login_required'             => 'You must be logged in to perform this action',
];
