import 'jquery';
import Ajax from 'elgg/Ajax';

// Elgg 7: use the elgg/Ajax module; the legacy global elgg.action is gone.
const ajax = new Ajax();

$(document).on('submit', '.event-carpool-feedback-form', function (e) {
	e.preventDefault();

	const $form = $(this);
	const url = $form.attr('action');
	if (!url) {
		return;
	}

	// ajax.action() displays the response system messages automatically.
	ajax.action(url, {
		data: ajax.objectify($form),
		success: () => {
			$form.find('textarea[name="message"]').val('');
		}
	});
});
