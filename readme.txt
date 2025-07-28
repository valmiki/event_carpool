### Installation and Testing
1. Place the `event_carpool` directory in the `mod/` directory of your Elgg installation.
2. Ensure the Event Manager plugin ([https://github.com/ColdTrick/event_manager](https://github.com/ColdTrick/event_manager)) is installed and enabled.
3. Enable the `event_carpool` plugin via the Elgg admin panel.
4. Test the plugin by navigating to an event page, submitting carpool offers and requests, and verifying they display correctly.

### Compatibility Notes
- The plugin uses standard Elgg functions (`elgg_register_entity_type()`, `elgg_extend_view()`, `elgg_register_action()`) that are compatible with Elgg 6.2.3, based on available documentation ([http://learn.elgg.org/en/stable/guides/plugins.html](http://learn.elgg.org/en/stable/guides/plugins.html)).
- The plugin assumes the Event Manager plugin uses the `event_manager/event/view` view, which should be verified against the latest version of the Event Manager plugin.
- Manual matching is implemented; automated matching would require additional logic, such as geolocation integration, which is not included here.

### Table: Plugin Components
| Component | File Path | Purpose |
|-----------|-----------|---------|
| Plugin Metadata | `elgg-plugin.php` | Defines plugin metadata and bootstrap class |
| Bootstrap Class | `classes/EventCarpool/Bootstrap.php` | Initializes plugin, registers entities, views, and actions |
| Language Strings | `languages/en.php` | Defines user-facing text |
| Offer View | `views/default/event_carpool/offers.php` | Displays carpool offers and submission form |
| Request View | `views/default/event_carpool/requests.php` | Displays carpool requests and submission form |
| Offer Form | `forms/event_carpool/add_offer.php` | Form for submitting carpool offers |
| Request Form | `forms/event_carpool/add_request.php` | Form for submitting carpool requests |
| Offer Action | `actions/event_carpool/add_offer.php` | Handles offer submission and saves entity |
| Request Action | `actions/event_carpool/add_request.php` | Handles request submission and saves entity |
| Offer Entity View | `views/default/object/carpool_offer.php` | Renders individual carpool offer display |
| Request Entity View | `views/default/object/carpool_request.php` | Renders individual carpool request display |

### Future Enhancements
- **Automated Matching**: Implement logic to match offers and requests based on pickup points or geolocation data.
- **Structured Pickup Points**: Replace text-based pickup points with a structured format (e.g., coordinates or predefined locations).
- **Notifications**: Add notifications to alert users when new offers or requests are posted for an event.

### Citations
- [Elgg Plugin Guide](http://learn.elgg.org/en/stable/guides/plugins.html)
- [Elgg Plugin Bootstrap](http://learn.elgg.org/en/stable/guides/plugins/bootstrap.html)
- [Event Manager Plugin](https://github.com/ColdTrick/event_manager)