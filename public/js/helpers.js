(function($) {
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });
})(jQuery); // End of use strict


window.addEventListener('DOMContentLoaded', function () {
    var scripts = [
            'js/bootbox.min.js',
            'js/cookie.min.js'],
        body = document.getElementsByTagName("body")[0], script;
    if (window.location.pathname.indexOf("dashboard/messages") > -1) {
        scripts.push('js/messaging.js');
    }
    for (var i = 0; i < scripts.length; i++) {
        script = document.createElement('script');
        script.setAttribute("type", "text/javascript");
        script.setAttribute("src", base_url() + scripts[i]);
        body.appendChild(script);
    }
});

function addJquery(body, link) {
    var script = document.createElement('script');
    script.setAttribute("type", "text/javascript");
    script.setAttribute("src", link);
    body.appendChild(script);

}

function buttonDisable(buttonName) {
    document.body.style.cursor = "wait";
    document.getElementById(buttonName).style.cursor = "wait";
    document.getElementById(buttonName).disabled = true;
}

function base_url() {
    // get the segments
    pathArray = window.location.pathname.split('/');
    // find where the segment is located
    indexOfSegment = pathArray.indexOf('public');

    if (indexOfSegment != -1) {
        // make base_url be the origin plus the path to the segment
        return window.location.origin + pathArray.slice(0, indexOfSegment + 1).join('/') + '/';
    } else
        return window.location.origin + '/';
}