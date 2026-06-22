/**
 * Customizer Controller Logic for Multi-Choice Button Segments
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Monitor adjustments inside active segmented checkbox targets
        $(document).on('change', '.blogus-group-checkbox', function() {
            // Scope everything inside the specific parent control element wrapper
            var $controlContainer = $(this).closest('.customize-control');
            var $groupContainer = $(this).closest('.blogus-btn-group');
            var checkedValues = [];
            
            // Collate checked nodes only inside this specific button group
            $groupContainer.find('.blogus-group-checkbox:checked').each(function() {
                checkedValues.push($(this).val());
            });
            
            // Target ONLY the hidden input that belongs inside this specific control element wrapper
            $controlContainer.find('input[type="hidden"]').val(checkedValues.join(',')).trigger('change');
        });
    });

})(jQuery);