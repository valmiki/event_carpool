<?php
namespace EventCarpool;

use Elgg\DefaultPluginBootstrap;

/**
 * Fixes vs. the original:
 *  - View extension is registered in init() (conventional, no timing
 *    doubt) instead of ready().
 *  - Dropped the `route`,`view:object:event` handler: the route event
 *    matches on the first URL segment, not the full route name, so it
 *    never fired. It's also unnecessary — the carpool view reads the
 *    event from $vars, not from the page owner (event_manager 21's event
 *    resource does not set the event as page owner).
 *  - Dropped the view_vars context handler for the same reason.
 *  - No double action registration (actions live in elgg-plugin.php).
 */
class Bootstrap extends DefaultPluginBootstrap {

	public function init() {
		// Plugin styling.
		elgg_extend_view('elgg.css', 'css/event_carpool.css');

		// Append the carpool block to the full event view.
		// event_manager >= 21.2 no longer renders a single event through
		// event_manager/event/view (object/event.php was replaced by
		// object/event/full.php, which composes the subviews directly), so
		// an extension on that view is never executed. The subview
		// event_manager/event/view/location exists in 21.1 and 21.2 and is
		// rendered by both full views; extensions are rendered even when the
		// base view returns early because there are no location details.
		if (elgg_view_exists('object/event/full')) {
			// event_manager >= 21.2
			elgg_extend_view('event_manager/event/view/location', 'event_carpool/carpool', 500);
		} else {
			// event_manager <= 21.1
			elgg_extend_view('event_manager/event/view', 'event_carpool/carpool', 500);
		}
	}
}
