"use strict";

$(document).ready(function () {
    var lastConvId = $('meta[name=last-conv]').attr('content');
    showConversation(lastConvId);

    $('#conversation-content').bind('mouseenter', chk_scroll);
    $('#send-button').bind('click', chk_scroll);

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
});

var userType = $('meta[name=userType]').attr('content');

function chk_scroll(e) {
    var elem = $(e.currentTarget);
    if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
       // $('#conversation-content').unbind('mouseenter', chk_scroll);
    }else{
        $('#conversation-content').animate({scrollTop: $('#conversation-content')[0].scrollHeight});
    }
}

function showConversation(conversation_id,cookieId,overview) {
    setCookie("offset", 0, 1);
    var offset = parseInt(cookie.get('offset'));
    setCookie("conversationId", conversation_id, 1);
    setCookie("Current-conv", conversation_id, 1);
    resetMessageBox();
    resetConversationWindow();
    showOrRemoveBadge(false,conversation_id);

    var conId = cookie.get('conversationId');
    var conversation_content =  document.getElementById('initial-results');
    $.get(base_url() + "conversation/get?id=" + conversation_id + "&offset=" +  offset + "&size=10")
        .done(function (data) {
            if(conId === cookie.get('conversationId')) {
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
                        if(overview != null && cookieId != null) {
                            document.getElementById('conversation-title-anchor').href = base_url() + overview + "/" + cookie.get(cookieId);
                        }
                    }
                    updateHiddenFields(attrValue.visitor_id, attrValue.provider_id, conversation_id);
                }
                wrapResults();
            }
        }).fail(function(error) {
            console.log(error);
    });
    getOfferedSearches();
    scrollToBottom();
    offset = offset + 10;
    setCookie('offset', offset, 1);
}

function wrapResults(){
    var allElements = $('#conversation-content .row'),
        WRAP_BY = 100000;
    for (var i = 0; i < allElements.length; i += WRAP_BY) {
        allElements.slice(i, i + WRAP_BY).wrapAll('<div class="container-fluid" id="fluid-wrapper" />');
    }
}

function addMoreResultsField(conversation_id){
    document.getElementById('loadMoreField').innerHTML += '<div class="loadMore text-center" id="' + conversation_id + '" onclick="showMoreMessages(' + conversation_id + ')"> Load earlier messages </div>';
}

function showMoreMessages(conversation_id) {
    var offset = parseInt(cookie.get('offset'));
    var prev = document.getElementById('more-results').innerHTML;
    var conversation_content = document.getElementById('more-results');
    conversation_content.innerHTML = " ";
    conversation_id = cookie.get('conversationId');
    $.get(base_url() + "conversation/get?id=" + conversation_id + "&offset=" +  offset + "&size=10")
        .done(function (data) {
            data.reverse();
            if(data.length <= 10){
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

function resetMessageBox(){
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
        if(position === 'right') {
            conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">'
                + '<a href="" data-lightbox="image-1" id="href-' + attrValue.attachments + '"><img src="" id="image-' + attrValue.attachments + '"/> </a></div></div>';
        }else{
            conversation_content.innerHTML = conversation_content.innerHTML + '<div class="row"><div class="col-md-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">'
                + '<a href="" data-lightbox="image-1" id="href-' + attrValue.attachments + '"><img src="" id="image-' + attrValue.attachments + '"/> </a></div></div>';
        }
    } else {
        if(position === 'right') {
            conversation_content.innerHTML = conversation_content.innerHTML
                + '<div class="row"><div class="col-md-6 col-md-offset-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">' +
                '<a download="" id="document-' + attrValue.attachments + '" href="">Download Document: </a></div></div>';
        }else{
            conversation_content.innerHTML = conversation_content.innerHTML
                + '<div class="row"><div class="col-md-6 message-box ' + position + ' embedded-image" id="attachment-' + attrValue.attachments + '">' +
                '<a download="" id="document-' + attrValue.attachments + '" href="">Download Document: </a></div></div>';
        }
    }

    var url = (attrValue.who === 'provider') ? base_url() + "fileentry/get/" + attrValue.attachments + "/" + cookie.get('providerId') :
    base_url()  + "fileentry/get/" + attrValue.attachments + "/" + cookie.get('visitorId');

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
                    '<h4>&pound;' + data['price'] + '</h4>' + '<h5>' + data['message'] + '</h5>';
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
                                        error: function (error) {
                                            console.log(error);
                                        },
                                        dataType: 'json',
                                        success: function (data) {
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
                                                $('#offered-searches-box').removeClass('hidden');
                                            }
                                        },
                                        type: 'GET'
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
                                        error: function (error) {
                                            console.log(error);
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data == 'declined') {
                                                $('#result').html("You successfully declined the offered search from " + document.getElementById('conversation-title').innerText + '!');
                                                $('#result').append('<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                                                $('#result').removeClass('hidden');
                                                $('#result').addClass('alert-success');

                                                $('#offered-searches-box').text(' ');
                                                $('#offered-searches-box').removeClass('hidden');
                                            }
                                        },
                                        type: 'GET'
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
                                        error: function (error) {
                                            console.log(error);
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data == 'cancelled') {
                                                $('#result').html("You successfully cancelled the offered search for " + document.getElementById('conversation-title').innerText + '!');
                                                $('#result').append('<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>');
                                                $('#result').removeClass('hidden');
                                                $('#result').addClass('alert-success');

                                                $('#offered-searches-box').text(' ');
                                                $('#offered-searches-box').removeClass('hidden');
                                            }
                                        },
                                        type: 'GET'
                                    });
                                }
                            }
                        });
                    });
                }
                $('#offered-searches-box').removeClass('hidden');
                $('#offer-a-search-button').addClass('hidden');
            }else{
                $('#offer-a-search-button').removeClass('hidden');
            }
        },
        type: 'GET'
    });
}