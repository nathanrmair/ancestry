$(function () {
    /** IE **/
    if (!String.prototype.startsWith) {
        String.prototype.startsWith = function (searchString, position) {
            position = position || 0;
            return this.indexOf(searchString, position) === position;
        };
    }
    /** END IE **/

    setCookie("userType", $('meta[name=userType]').attr('content'), 1);
    var max_file_size = 10485760; // 10 MB

    document.getElementById('fileinput').addEventListener('change', function () {
        var file = this.files[0];
        document.getElementById("file-chosen").innerText = "File chosen: " + file.name;
    }, false);

    var lastConvId = $('meta[name=last-conv]').attr('content');
    showConversation(lastConvId);

    $('#conversation-content').bind('mouseenter', chk_scroll);

    $('.conversation-column').click(function() {
        var id = $(this).attr('id');
        if(id !== cookie.get('conversationId')) {
            var user_id = $(this).attr('data'), user_title = '', overview, cookieId = '';
            if($('meta[name=userType]').attr('content') === 'visitor'){
                user_title = "#provider-name-" + user_id;
                overview = 'provider_overview';
                cookieId = 'providerId';
            }else{
                user_title = "#visitor-name-" + user_id;
                overview = 'visitor_overview';
                cookieId = 'visitorId';
            }

            $('#conversation-title').text($(user_title).text());
            var image = "#" + user_id;
            document.getElementsByClassName('avatar-top')[0].src = document.getElementById("user-avatar-" + user_id).src;
            document.getElementById('conversation-title-anchor').href = base_url() + overview + "/" + cookie.get(cookieId);
            setCookie('offset', 10 , 1);
            showConversation(id,cookieId,overview);

        }
    });
    setInterval(checkForResponse, 5000);
    setInterval(checkForNewMessagesInAllConversations, 10000);

    $('#send-button').click(function (e) {
        e.preventDefault();

        var message = $('textarea[name=message]').val();
        if (message.trim().length === 0) {
            bootbox.alert('Cannot send an empty message');
        } else {
            var formData = new FormData($('#new-message-form')[0]);
            if (document.getElementById('fileinput').files[0] && document.getElementById('fileinput').files[0].size > max_file_size) {
                bootbox.alert('File too large! Please select a file less than 10MB!');
            } else {
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });

                $.ajax({
                    url: base_url() + 'messages/new',
                    type: "post",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        if (data.errors === 1000) { // 1000 = NOT_ENOUGH_CREDITS
                            bootbox.confirm({
                                message: "It seems that you ran out of credits. Do you want to buy some more?",
                                callback: function (result) {
                                    if (result) {
                                        window.location.replace(base_url() + "profile/credits");
                                    }
                                }
                            });
                        } else {
                            if (data.attachment !== 'null' || data.message !== 'null') {
                                insertMessageCloud(data, 'right');
                                $("#conversation-content").animate({scrollTop: $('#conversation-content').prop("scrollHeight")}, 1000);
                            }
                            moveConversationToTop(cookie.get('conversationId'), message);
                        }
                    },
                    error: function (error) {
                    }
                });
                $('#new-message-form').get(0).reset();
                $("input[type='file']").replaceWith($("input[type='file']").clone(true)); // for IE
                document.getElementById("file-chosen").innerText = "";
                var id = "conversation-last-" + cookie.get('conversationId');
                document.getElementById(id).innerHTML = '<p>' + message + '</p>';
            }
        }
        chk_scroll();
    });

    $('#offer-a-search-button').click(function (e) {
        bootbox.dialog({
                title: "Offer a search",
                message: '<div class="row">  ' +
                '<div class="col-md-12"> ' +
                '<form class="form-horizontal" id="new-search-form" action="' + base_url() + '/messages/offerASearch" method="POST" role="form"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="price">Credits</label> ' +
                '<div class="col-md-4"> ' +
                '<input id="price-input" name="price" type="number" placeholder="Enter here" class="form-control input-md"> </div> ' +
                '</div> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="short-message">Message</label>' +
                '<div class="col-md-4"> ' +
                '<textarea class="form-control" rows="5" id="short-message" name="short-message" placeholder="Enter a short message for the user..."></textarea> ' +
                '</div></div>' +
                '<div class="form-group"> ' +
                '<label class="col-md-4 control-label" for="date-of-completion">Date Of Completion:</label>' +
                '<div class="col-md-4"> ' +
                '<input data-provide="datepicker" data-date-format="dd/mm/yyyy" name="date-of-completion" readonly="readonly" placeholder="Click to choose.." id="date-of-completion" class="datepicker form-control input-md" /> ' + '</div></div>' +
                '<input type="hidden" name="conversation_id" value="' + cookie.get('conversationId') + '"/>' +
                '<input type="hidden" name="_token" id="csrf-token" value="' + $('meta[name=_token]').attr('content') + '" />' +
                '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Offer",
                        className: "btn-success",
                        callback: function () {
                            document.getElementById("new-search-form").submit();
                            $('#result').html("You successfully offered a search to " + document.getElementById('conversation-title').innerText + '!');
                            $('#result').append('<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                            $('#result').removeClass('hidden');
                            $('#result').addClass('alert-success');
                        }
                    }
                }
            }
        );
        $("#date-of-completion").datepicker({
            dateFormat: 'dd-mm-yy',
            yearRange: '+0:+1',
            minDate: new Date(),
            defaultDate: +7,
            changeYear: true,
            changeMonth: true
        });
    })
});

var conversation_id = 0,
    provider_id = 0,
    visitor_id = 0,
    userType = $('meta[name=userType]').attr('content');

function resetFormElement() {
    var $el = $('#fileinput');
    $el.wrap('<form>').closest('form').get(0).reset();
    $el.unwrap();
}

function checkForNewMessagesInAllConversations() {

    var ids = $.map($('#conversation-list a'), function (n, i) {
        return n.id;
    });

    for (var i = 0, length = ids.length; i < length; i++) {
        doAjax(ids, base_url() + 'messages/checkForNew?id=' + ids[i], i);
    }
}

function doAjax(ids, url, index) {

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (data) {
            if (data.message !== 'null') {
                moveConversationToTop(ids[index], JSON.parse(data.message).message);
                showOrRemoveBadge(true, ids[index]);
            }
        }
    });
}

function moveConversationToTop(id, message) {
    var ids = $.map($('#conversation-list a'), function (n, i) {
        return n.id;
    });
    var firstid = "#" + ids[0];
    var idElement = "#" + id;
    var badgeid = "#message-badge-" + id;

    $(idElement).css('opacity', 0.4);
    $(idElement).insertBefore(firstid).animate({
        opacity: 1
    }, 1000);
    $(badgeid).text('new');
    var msg = "#conversation-last-" + id;
    $(msg).html('<p>' + message + '</p>');
}

function showOrRemoveBadge(show, conId) {
    var badgeid = "#message-badge-" + conId;
    if (show) {
        $(badgeid).removeClass('hidden');
    } else {
        $(badgeid).addClass('hidden');
    }
}

function checkForResponse() {
    conversation_id = cookie.get('conversationId');
    var url = base_url() + 'messages/checkForNew?id=' + conversation_id;
    $.get(url).done(function (data) {
        if (data.attachment !== 'null' || data.message !== 'null') {
            insertMessageCloud(data, 'left');
            $("#conversation-content").animate({scrollTop: $('#conversation-content').prop("scrollHeight")}, 1000);
        }
    });
}

/**
 * Inserts a new message cloud to the message window
 */
function insertMessageCloud(data, position) {
    var messageArray = JSON.parse(data.message);
    var conversation_content = document.getElementById('fluid-wrapper');
    if (position === 'right') {
        conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box  pull-' + position + ' ' + position + '">' + messageArray.message + '</div></div>';
    } else {
        conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 message-box  pull-' + position + ' ' + position + '">' + messageArray.message + '</div></div>';
    }
    if (data.attachment !== 'null') {
        var attachment = JSON.parse(data.attachment);
        file = attachment['filename'];
    } else {
        file = 'null';
    }
    var id = "conversation-last-" + cookie.get('conversationId');
    document.getElementById(id).innerHTML = '<p>' + messageArray.message + '</p>';

    if (file !== 'null') {
        if (attachment['mime'].startsWith('image/')) {
            if (position === 'right') {
                conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box pull-right ' + position + ' embedded-image" id="attachment-' + file + '">'
                    + '<a href="" data-lightbox="image-1" id="href-' + file + '"><img src="" id="image-' + file + '"/> </a></div></div>';
            } else {
                conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 message-box pull-left ' + position + ' embedded-image" id="attachment-' + file + '">'
                    + '<a href="" data-lightbox="image-1" id="href-' + file + '"><img src="" id="image-' + file + '"/> </a></div></div>';
            }
        } else {
            if (position === 'right') {
                conversation_content.innerHTML = conversation_content.innerHTML
                    + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box pull-right ' + position + ' embedded-image" id="attachment-' + file + '">' +
                    '<a download="" id="document-' + file + '" href="">Download: </a></div></div>';
            } else {
                conversation_content.innerHTML = conversation_content.innerHTML
                    + '<div class="row"><div class="col-md-6 message-box pull-left ' + position + ' embedded-image" id="attachment-' + file + '">' +
                    '<a download="" id="document-' + file + '" href="">Download: </a></div></div>';
            }
        }
        var url = (attachment['who'] === 'provider') ? base_url() + "fileentry/get/" + file + "/" + cookie.get('providerId') :
        base_url() + "fileentry/get/" + file + "/" + cookie.get('visitorId');
        $.ajax({
            url: url,
            processData: false,
            success: function (b64data) {
                if (attachment['mime'].startsWith('image/')) {
                    document.getElementById("image-" + file).setAttribute("src", "data:" + attachment['mime'] + ";base64," + b64data.base64_data);
                } else {
                    document.getElementById("document-" + file).setAttribute("href", "data:" + b64data.mime + ";base64," + b64data.base64_data);
                    document.getElementById("document-" + file).setAttribute("download", b64data.original_name);
                    document.getElementById("document-" + file).innerText = "Download: " + b64data.original_name;
                }
            },
            error: function (error) {
                console.log('Whoops something went wrong');
            }
        });
    }
}

function showConversation(conversation_id, cookieId, overview) {
    setCookie("offset", 0, 1);
    var offset = parseInt(cookie.get('offset'));
    setCookie("conversationId", conversation_id, 1);
    setCookie("Current-conv", conversation_id, 1);
    resetMessageBox();
    resetConversationWindow();
    showOrRemoveBadge(false, conversation_id);

    var conId = cookie.get('conversationId');
    var conversation_content = document.getElementById('initial-results');
    $.get(base_url() + "conversation/get?id=" + conversation_id + "&offset=" + offset + "&size=10")
        .done(function (data) {
            if (conId === cookie.get('conversationId')) {
                var size = Object.keys(data).length;
                if (size >= 10) {
                    addMoreResultsField(conversation_id);
                }
                data.reverse();
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        var attrValue = data[key];
                        if (attrValue.who == userType) {
                            conversation_content.innerHTML += '<div class="row"><div class="col-md-6 col-md-offset-6 message-box pull-right right">' + attrValue.message + '</div></div> ';
                            if (attrValue.attachments != null) {
                                getDocument(attrValue, conversation_content, "pull-right right");
                            }
                        } else {
                            conversation_content.innerHTML += '<div class="row"><div class="col-md-6 message-box pull-left left">' + attrValue.message + '</div></div>';
                            if (attrValue.attachments != null) {
                                getDocument(attrValue, conversation_content, "pull-left left");
                            }

                        }
                        setCookie("visitorId", attrValue.visitor_id, 1);
                        setCookie("providerId", attrValue.provider_id, 1);
                        if (overview != null && cookieId != null) {
                            document.getElementById('conversation-title-anchor').href = base_url() + overview + "/" + cookie.get(cookieId);
                        }
                    }
                    updateHiddenFields(attrValue.visitor_id, attrValue.provider_id, conversation_id);
                }
                wrapResults();
            }
        }).fail(function (error) {
        console.log(error);
    });
    getOfferedSearches();
    scrollToBottom();
    offset = offset + 10;
    setCookie('offset', offset, 1);
}

function wrapResults() {
    var allElements = $('#conversation-content .row'),
        WRAP_BY = 100000;
    for (var i = 0; i < allElements.length; i += WRAP_BY) {
        allElements.slice(i, i + WRAP_BY).wrapAll('<div class="container-fluid" id="fluid-wrapper" />');
    }
}

function addMoreResultsField(conversation_id) {
    document.getElementById('loadMoreField').innerHTML += '<div class="loadMore text-center" id="' + conversation_id + '" onclick="showMoreMessages(' + conversation_id + ')"> Load earlier messages </div>';
}

function showMoreMessages(conversation_id) {
    var offset = parseInt(cookie.get('offset'));
    var prev = document.getElementById('more-results').innerHTML;
    var conversation_content = document.getElementById('more-results');
    conversation_content.innerHTML = " ";
    conversation_id = cookie.get('conversationId');
    $.get(base_url() + "conversation/get?id=" + conversation_id + "&offset=" + offset + "&size=10")
        .done(function (data) {
            data.reverse();
            if (data.length <= 10) {
                document.getElementById('loadMoreField').innerHTML = " ";
            }
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var attrValue = data[key];

                    if (attrValue.who == userType) {
                        conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box pull-right right">' + attrValue.message + '</div></div>';
                        if (attrValue.attachments != null) {
                            getDocument(attrValue, conversation_content, "pull-right right");
                        }
                    } else {
                        conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 message-box pull-left left">' + attrValue.message + '</div></div>';
                        if (attrValue.attachments != null) {
                            getDocument(attrValue, conversation_content, "pull-left left");
                        }
                    }
                }
            }
            wrapResults();
            conversation_content.innerHTML += prev;
        });

    offset = offset + 10;
    setCookie('offset', offset, 1);
    scrollToBottom();
}

function resetConversationWindow() {
    document.getElementById('more-results').innerHTML = " ";
    document.getElementById('initial-results').innerHTML = " ";
    document.getElementById('loadMoreField').innerHTML = " ";
    document.getElementById('offered-searches-box').innerHTML = "";
}

function setChunkAndOffset() {
    var offset = cookie.get('offset');
    setCookie("offset", offset + 10, 1);
}

function resetMessageBox() {
    $('#new-message-form').get(0).reset();
    $('#file-chosen').text('');
}

function scrollToBottom() {
    // var objDiv = document.getElementById("conversation-content");
    // objDiv.scrollTop = objDiv.scrollHeight;
    var d = $('#conversation-content');
    d.scrollTop(d.prop("scrollHeight"));
}

function getDocument(attrValue, conversation_content, position) {
    if (attrValue.mime.startsWith('image/')) {
        if (position === 'right') {
            conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">'
                + '<a href="" data-lightbox="image-1" id="href-' + attrValue.attachments + '"><img src="" id="image-' + attrValue.attachments + '"/> </a></div></div>';
        } else {
            conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">'
                + '<a href="" data-lightbox="image-1" id="href-' + attrValue.attachments + '"><img src="" id="image-' + attrValue.attachments + '"/> </a></div></div>';
        }
    } else {
        if (position === 'right') {
            conversation_content.innerHTML = conversation_content.innerHTML
                + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">' +
                '<a download="" id="document-' + attrValue.attachments + '" href="">Download Document: </a></div></div>';
        } else {
            conversation_content.innerHTML = conversation_content.innerHTML
                + '<div class="row"><div class="col-md-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">' +
                '<a download="" id="document-' + attrValue.attachments + '" href="">Download Document: </a></div></div>';
        }
    }

    var url = (attrValue.who === 'provider') ? base_url() + "fileentry/get/" + attrValue.attachments + "/" + cookie.get('providerId') :
    base_url() + "fileentry/get/" + attrValue.attachments + "/" + cookie.get('visitorId');

    $.ajax({
        url: url,
        processData: false,
    }).done(function (b64data) {
        if (b64data.mime.startsWith('image/')) {
            document.getElementById("image-" + attrValue.attachments).setAttribute("src", "data:" + b64data.mime + ";base64," + b64data.base64_data);
            document.getElementById("href-" + attrValue.attachments).setAttribute("href", "data:" + b64data.mime + ";base64," + b64data.base64_data);
        } else {
            document.getElementById("document-" + attrValue.attachments).setAttribute("href", "data:" + b64data.mime + ";base64," + b64data.base64_data);
            document.getElementById("document-" + attrValue.attachments).setAttribute("download", b64data.original_name);
            document.getElementById("document-" + attrValue.attachments).innerText = "Download Document: " + b64data.original_name;
        }
    });
}

function setCookie(cname, cvalue, exdays) {
    cookie.set(cname, cvalue, {
        expires: exdays,
        path: "/",
        secure: false
    });
}

function updateHiddenFields(visitorId, providerId, conversationId) {
    $('input[name=visitorId]').val(visitorId);
    $('input[name=providerId]').val(providerId);
    $('input[name=conversationId]').val(conversationId);
}

function getOfferedSearches() {
    document.getElementById('offered-searches-box').innerHTML = "<h3>Offered Searches</h3>";
    $.ajax({
        url: base_url() + "messages/getOfferedSearches",
        data: {
            conversation_id: cookie.get('conversationId')
        },
        error: function (error) {
            console.log(error);
        },
        dataType: 'json',
        success: function (data) {
            if (data !== null) {
                var offered_searches_content = '<div class="w3-card-8 col-md-offset-2 col-md-7" >'
                    + '<div class="w3-container w3-center">' +
                    '<h3>Search Offer</h3> ' +
                    '<h4>Credits: ' + data['price'] + '</h4>' + '<h5>' + data['message'] + '</h5>';
                if (cookie.get('userType') === 'visitor') {
                    offered_searches_content += '<div class="w3-section"><button class="w3-btn w3-green accept-offer" id="accept-button' + data['offered_search_id'] + '">Accept</button>' +
                        '<button class="w3-btn w3-red decline-offer" id="decline-button' + data['offered_search_id'] + '">Decline</button></div></div> </div>';
                    document.getElementById('offered-searches-box').innerHTML += offered_searches_content;
                    $('.accept-offer').click(function (e) {
                        bootbox.confirm({
                            message: 'Are you sure you want to accept this offered search for ' + data['price'] + '?',
                            callback: function (result) {
                                if (result) {
                                    $.ajax({
                                        url: base_url() + "/messages/acceptSearchOffer",
                                        data: {
                                            conversation_id: cookie.get('conversationId')
                                        },
                                        type: 'GET'
                                    })
                                        .done(function(data,status){
                                            if (data.errors === 1000) { // 1000 = NOT_ENOUGH_CREDITS
                                                bootbox.confirm({
                                                    message: "You do not have enough credits to accept this offer. Do you want to buy some more?",
                                                    callback: function (result) {
                                                        if (result) {
                                                            window.location.replace(base_url() + "profile/credits");
                                                        }
                                                    }
                                                });
                                            } else if (data == 'accepted') {
                                                $('#result').html("You successfully accepted the offered search from " + document.getElementById('conversation-title').innerText + '!');
                                                $('#result').append('<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                                                $('#result').removeClass('hidden');
                                                $('#result').addClass('alert-success');

                                                $('#offered-searches-box').text(' ');
                                                $('#offered-searches-box').addClass('hidden');
                                            }
                                        })
                                        .fail(function(data,status){
                                            console.log(data);
                                        });
                                }
                            }

                        });
                    });

                    $('.decline-offer').click(function (e) {
                        bootbox.confirm({
                            message: 'Are you sure you want to decline this offered search for ' + data['price'] + '?',
                            callback: function (result) {
                                if (result) {
                                    $.ajax({
                                        url: base_url() + "/messages/declineSearchOffer",
                                        data: {
                                            conversation_id: cookie.get('conversationId')
                                        },
                                        type: 'GET'
                                    }).done(function(data,status){
                                        if (data == 'declined') {
                                            $('#result').html("You successfully declined the offered search from " + document.getElementById('conversation-title').innerText + '!');
                                            $('#result').append('<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                                            $('#result').removeClass('hidden');
                                            $('#result').addClass('alert-success');

                                            $('#offered-searches-box').text(' ');
                                            $('#offered-searches-box').addClass('hidden');
                                        }
                                    })
                                        .fail(function(data,status){
                                            console.log(data);
                                        });
                                }
                            }
                        });
                    });
                } else {
                    offered_searches_content += '<div class="w3-section"><button class="w3-btn w3-red cancel-offer" id="cancel-button' + data['offered_search_id'] + '">Cancel</button></div></div> </div>';
                    document.getElementById('offered-searches-box').innerHTML += offered_searches_content;
                    $('.cancel-offer').click(function (e) {
                        bootbox.confirm({
                            message: 'Are you sure you want to cancel this offered search for ' + data['price'] + '?',
                            callback: function (result) {
                                if (result) {
                                    $.ajax({
                                        url: base_url() + "/messages/cancelSearchOffer",
                                        data: {
                                            conversation_id: cookie.get('conversationId')
                                        },
                                        type: 'GET'
                                    }).done(function(data,status){
                                        if (data == 'cancelled') {
                                            $('#result').html("You successfully cancelled the offered search for " + document.getElementById('conversation-title').innerText + '!');
                                            $('#result').append('<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                                            $('#result').removeClass('hidden');
                                            $('#result').addClass('alert-success');

                                            $('#offered-searches-box').text(' ');
                                            $('#offered-searches-box').addClass('hidden');
                                        }
                                    })
                                        .fail(function(data,status){
                                            console.log(data);
                                        });
                                }
                            }
                        });
                    });
                }
                $('#offered-searches-box').removeClass('hidden');
                $('#offer-a-search-button').addClass('hidden');
            } else {
                $('#offer-a-search-button').removeClass('hidden');
            }
        },
        type: 'GET'
    });
}

function chk_scroll(e) {
    var elem = $(e.currentTarget);
    if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
        // $('#conversation-content').unbind('mouseenter', chk_scroll);
    } else {
        $('#conversation-content').animate({scrollTop: $('#conversation-content')[0].scrollHeight});
    }
}
