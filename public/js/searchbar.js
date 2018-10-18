$(function () {
    "use strict";

    $('#search-button').click(function (event) {
        deleteMarkers();
        search();
    });

    $('#show-all').click(function (event) {
        deleteMarkers();
        showAll();
    });

    $('#search-box').bind('keypress', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            deleteMarkers();
            search();
        }
    });

});

function search() {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    var query = $('input[name=search-query]').val();
    $.ajax({
        url: base_url() + 'search/query',
        type: "get",
        data: {"query": query},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            var tableBody = " ";
            $('#results-table').css('visibility', 'visible');
            $('#no-results-found').css('visibility', 'hidden');
            $('#results-table tbody').empty();
            if (data[0] == null) {
                $('#results-table').css('visibility', 'hidden');
                $('#no-results-found').css('visibility', 'visible');
            }
            var i = 1;
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var attrValue = data[key];
                    var markerMessage = '<a href=' + base_url() + 'provider_overview/' + attrValue.user_id + '> ' + attrValue.name + '</a>';
                    tableBody += '';
                    tableBody += '<tr id="search_tr"> <td><a href=' + base_url() + 'provider_overview/' + attrValue.user_id + '> ' + attrValue.name + '</a></td>';
                    tableBody += '<td> ' + attrValue.postcode + '</td>';
                    tableBody += '<td> ' + attrValue.type + '</td>';
                    addMarkerByAddress(markerMessage, attrValue.postcode, attrValue.type, i * 200);
                }
                i++;
            }
            //$('.table tbody').html(tableBody);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function showAll(){
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    var query = '*';
    $.ajax({
        url: base_url() + 'search/query',
        type: "get",
        data: {"query": query},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            var tableBody = " ";
            $('#results-table').css('visibility', 'visible');
            $('#no-results-found').css('visibility', 'hidden');
            $('#results-table tbody').empty();
            if (data[0] == null) {
                $('#results-table').css('visibility', 'hidden');
                $('#no-results-found').css('visibility', 'visible');
            }
            var i = 1;
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var attrValue = data[key];
                    var markerMessage = '<a href=' + base_url() + 'provider_overview/' + attrValue.user_id + '> ' + attrValue.name + '</a>';
                    addMarkerByAddress(markerMessage, attrValue.postcode, attrValue.type, i * 200);
                    tableBody += '';
                    tableBody += '<tr id="search_tr"> <td><a href=' + base_url() + 'provider_overview/' + attrValue.user_id + '> ' + attrValue.name + '</a></td>';
                    tableBody += '<td> ' + attrValue.postcode + '</td>';
                    tableBody += '<td> ' + attrValue.type + '</td>';
                }
                i++;
            }
            $('.table tbody').html(tableBody);
        },
        error: function (error) {
            console.log(error);
        }
    });
}