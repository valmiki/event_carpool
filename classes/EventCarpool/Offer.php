<?php
namespace EventCarpool;

use ElggObject;

/**
 * Carpool offer entity — object subtype "event_carpool_offer".
 *
 * Elgg 7 made ElggObject abstract, so `new ElggObject()` fatals with
 * "Cannot instantiate abstract class ElggObject". Each object subtype
 * now needs its own concrete class, registered in the `entities`
 * section of elgg-plugin.php. Instantiate this class (new Offer()) when
 * creating an offer, and Elgg will also use it to load saved offers.
 */
class Offer extends ElggObject {

    protected function initializeAttributes() {
        parent::initializeAttributes();
        $this->attributes['subtype'] = 'event_carpool_offer';
    }
}
