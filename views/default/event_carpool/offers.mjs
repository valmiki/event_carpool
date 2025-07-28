import 'elgg';
import $ from 'jquery';

if (typeof elgg.action !== 'function') {
    console.error('Event Carpool: elgg.action is niet beschikbaar', elgg);
    if (typeof elgg.system_message === 'function') {
        elgg.system_message('Fout: AJAX-functionaliteit niet geladen', 'error');
    } else {
        alert('Fout: AJAX-functionaliteit niet geladen');
    }
    return;
}

// Handle offer edit actions
$('.elgg-item').on('click', '.elgg-action-offer', function(e) {
    e.preventDefault();
    const $elem = $(this);
    elgg.action($elem.attr('href'), {
        data: {
            guid: $elem.data('guid'),
        },
        success: (result) => {
            if (result.system_messages.success) {
                elgg.system_message(result.system_messages.success);
            }
        },
        error: (result) => {
            if (result.system_messages.error) {
                elgg.register_error(result.system_messages.error);
            }
        }
    });
});

console.log('Event Carpool: elgg module loaded');