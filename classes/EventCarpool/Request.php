<?php
namespace EventCarpool;

use ElggObject;

/**
 * Carpool request entity — object subtype "event_carpool_request".
 *
 * See EventCarpool\Offer for why this concrete class is required in
 * Elgg 7 (ElggObject is abstract).
 */
class Request extends ElggObject {

    protected function initializeAttributes() {
        parent::initializeAttributes();
        $this->attributes['subtype'] = 'event_carpool_request';
    }
}
