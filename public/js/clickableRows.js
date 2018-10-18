/**
 * Created by yhb15154 on 25/07/2016.
 */

jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
