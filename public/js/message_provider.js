$(function () {
    $("#new-message").click(function (event) {
        promptForNewMessage(event);
    });
});


function promptForNewMessage(event) {

    $.get(base_url() + 'search/isLogged').done(function (data) {
        if (data.success) {
            if (data.errors === 2000) {
                bootbox.alert('You need to upgrade to a member to send messages.');
            } else {
                var name = event.target.dataset.userName;
                var id = event.target.dataset.userId;
                bootbox.dialog({
                        title: "Send a message to " + name,
                        message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal"> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-2 control-label" for="message">Message</label> ' +
                        '<div class="col-md-10"> ' +
                        '<textarea class="form-control vresize" name="message" id="new-message-textarea" placeholder="Enter your message here"></textarea></div> </div> </form> </div>  </div>',
                        buttons: {
                            success: {
                                label: "Send",
                                className: "btn-primary",
                                callback: function () {
                                    sendNewMessage(id);
                                }
                            }
                        }
                    }
                );
            }
        }else {
            bootbox.confirm({
                message: "You need to be logged in to send messages!",
                callback: function (result) {
                    if (result) {
                        window.location.replace(base_url() + "login");
                    }
                }
            });

        }
    }).fail(function (data) {
        console.log(data);
    });


}

function sendNewMessage(provider_id) {
    var message = $('textarea[name=message]').val();
    if (message.trim().length === 0) {
        bootbox.alert('Cannot send an empty message');
    } else {
        bootbox.confirm({
            message: "Please note that the first message to a provider costs 20 credits." +
            " Every subsequent message will cost 5 credits." +
            " If this is your first message to this provider you will be charged 20 credits." +
            " Are you sure you want to proceed? ",
            callback: function (result) {
                if (result) {
                    var formData = new FormData();
                    formData.append("providerId", provider_id);
                    formData.append("message", message);
                    $.ajaxSetup({
                        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                    });

                    $.ajax({
                        url: base_url() + 'messages/conversation/new',
                        type: "post",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if (data.errors === 1000) {
                                bootbox.confirm({
                                    message: "It seems that you ran out of credits. Do you want to buy some more?",
                                    callback: function (result) {
                                        if (result) {
                                            window.location.replace(base_url() + "profile/credits");
                                        }
                                    }
                                });
                            } else if (data.errors === 3000) {
                                window.location.replace(base_url() + "/profile/dashboard/messages");
                            } else {
                                window.location.replace(base_url() + "/profile/dashboard/messages");
                            }
                        }
                    });
                }
            }
        });


    }
}
