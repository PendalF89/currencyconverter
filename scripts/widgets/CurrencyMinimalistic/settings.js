jQuery(document).ready(function($){
    // Тут работает
    console.log( 'run baby' );

    function init() {
        $('#widgets-right *[data-currency-converter-palettes-switcher="true"] .currency-converter_minimalistic-container').click(function(event){

            // А тут уже не работает
            console.log('heeeey');

            if (typeof $(event.target).data('bg_color_1') !== 'undefined') {
                $(   '#' + $(event.target).data('bg_color_1-target-id')   )
                    .val( $(event.target).data('bg_color_1') )
                    .iris('color', $(event.target).data('bg_color_1'));
            }

            if (typeof $(event.target).data('bg_color_2') !== 'undefined') {
                $(   '#' + $(event.target).data('bg_color_2-target-id')   )
                    .val( $(event.target).data('bg_color_2') )
                    .iris('color', $(event.target).data('bg_color_2'));
            }

            if (typeof $(event.target).data('color') !== 'undefined') {
                $(   '#' + $(event.target).data('color-target-id')   )
                    .val( $(event.target).data('color') )
                    .iris('color', $(event.target).data('color'));
            }

            if (typeof $(event.target).data('separator_color') !== 'undefined') {
                $(   '#' + $(event.target).data('separator_color-target-id')   )
                    .val( $(event.target).data('separator_color') )
                    .iris('color', $(event.target).data('separator_color'));
            }

            if (typeof $(event.target).data('separator_opacity') !== 'undefined') {
                $(   '#' + $(event.target).data('separator_opacity-target-id')   )
                    .val( $(event.target).data('separator_opacity') );
            }

        });
    }

}(jQuery));
