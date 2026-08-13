# Event Carpool

An [Elgg](https://elgg.org) plugin that adds carpooling to events managed by the
[ColdTrick Event Manager](https://github.com/ColdTrick/event_manager) plugin.
On any event with a physical location, attendees can offer a ride or request one,
respond to each other, and manage their own entries — all directly on the event page.

## Features

- **Offer a ride** — share the number of available seats, pickup points and notes.
- **Request a ride** — state how many seats you need, your pickup location and notes.
- **Respond** — a message form lets a non-owner contact the driver (on an offer) or
  the requester (on a request) by e-mail.
- **Manage your own entries** — the owner can close (mark as full/handled) or delete
  an offer or request, updated live without a page reload.
- **Location-aware** — the carpool block is hidden automatically on online events and
  any event without a venue or location, where carpooling doesn't apply.
- **Multilingual** — English and Dutch translations included.

## Requirements

- Elgg 6.3 or 7.0
- PHP 8.2 or newer
- ColdTrick Event Manager: version 20.x (for Elgg 6.3) or 21.x (for Elgg 7.0)

## Installation

1. Place this plugin in your site's `mod/` directory as `mod/event_carpool`
   (for example by cloning the repository or unpacking a release there).
2. Make sure a compatible version of **Event Manager** is installed and active.
3. In your Elgg admin area, go to **Administration → Plugins**, enable
   **Event Carpool**, and make sure it is ordered after Event Manager.
4. Flush the caches (**Administration → Flush caches**). If you are upgrading from
   an earlier version, deactivate and reactivate the plugin once so the entity
   classes are registered.

## Usage

Open any event that has a venue or location. Below the event, logged-in users see a
**Carpool Offers** and a **Carpool Requests** section, each with a form to add an
entry. Click an entry's heading to expand its details, contact the owner, or (if it
is yours) close or delete it. Events without a location do not show the carpool block.

## Compatibility notes

The plugin is written against the common Elgg API and runs on both the 6.3 and 7.0
lines with the matching Event Manager version. Elgg 7 made a few breaking changes
that this plugin already accounts for, including `ElggObject` becoming abstract
(the plugin registers its own `Offer` and `Request` entity classes) and the removal
of some legacy front-end helpers (it uses the current ESM / `elgg/Ajax` conventions).

## Languages

Translations live in `languages/`. English (`en.php`) and Dutch (`nl.php`) are
provided; contributions of additional languages are welcome.

## License

Released under the GNU General Public License v2.0 or later (GPL-2.0-or-later).
