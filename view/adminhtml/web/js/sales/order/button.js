define([
        'jquery'
    ], function (jQuery) {
    jQuery('#sales_order_create_customer_grid_table').click( function() {
            if (jQuery('#submit_order_top_button:visible')) {
                jQuery('#create-quote').show();
            }
        }
    );
    }
);

