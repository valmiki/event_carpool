import 'jquery';
import 'elgg';
import Ajax from 'elgg/Ajax';

// Elgg 7 convention: side-effect imports expose global $ and elgg.
(() => {
	const ajax = new Ajax();

	// Toggle details (works for offers and requests).
	$(document).on('click', '.carpool-offer-toggle, .carpool-request-toggle', function () {
		const $toggle = $(this);
		const $details = $toggle.closest('.elgg-listing')
			.find('.carpool-offer-details, .carpool-request-details');

		if ($details.is(':visible')) {
			$details.slideUp(150);
			$toggle.removeClass('carpool-offer-toggle-active carpool-request-toggle-active');
		} else {
			$details.slideDown(150);
			$toggle.addClass('carpool-offer-toggle-active carpool-request-toggle-active');
		}
	});

	function runAction($button, onSuccess) {
		const href = $button.attr('href');
		const guid = $button.data('guid');
		if (!href || !guid) {
			elgg.register_error('Missing action URL or GUID');
			return;
		}
		ajax.action(href, {
			data: { guid },
			success: (result) => {
				if (result?.system_messages?.success?.length) {
					elgg.system_message(result.system_messages.success.join('\n'));
				}
				onSuccess();
			},
			error: (result) => {
				if (result?.system_messages?.error?.length) {
					elgg.register_error(result.system_messages.error.join('\n'));
				}
			}
		});
	}

	// Delete: remove the whole list row.
	$(document).on('click', '.elgg-carpool-delete', function (e) {
		e.preventDefault();
		const $button = $(this);
		runAction($button, () => {
			const $li = $button.closest('li.elgg-item');
			const $target = $li.length ? $li : $button.closest('.carpool-item');
			$target.slideUp(200, () => $target.remove());
		});
	});

	// Close: keep the row, mark it closed in place (no reload needed).
	$(document).on('click', '.elgg-carpool-close', function (e) {
		e.preventDefault();
		const $button = $(this);
		runAction($button, () => {
			const $card = $button.closest('.carpool-item');
			$card.addClass('carpool-item-closed');

			// Badge in the header for immediate feedback.
			const label = (typeof elgg.echo === 'function')
				? elgg.echo('event_carpool:status_closed') : 'Closed';
			const $header = $card.find('.carpool-offer-toggle, .carpool-request-toggle').first();
			if ($header.find('.carpool-badge-closed').length === 0) {
				$header.append(' <span class="carpool-badge-closed">' + label + '</span>');
			}

			// A closed item can no longer be replied to; drop the contact form
			// and the close button (keep delete).
			$card.find('.carpool-contact-form').remove();
			$button.remove();
		});
	});
})();
