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

		// Append the carpool block to the full event view. event_manager
		// (v21) renders a single event through event_manager/event/view
		// (see its object/event.php full-view branch).
		elgg_extend_view('event_manager/event/view', 'event_carpool/carpool', 500);
	}
}
