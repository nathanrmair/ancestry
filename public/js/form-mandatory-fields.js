var valid = "green";
var invalid = "orange";

function setMandatoryFieldListeners(list) {
    var i = 0;
    var val;
    for (i = 0; i < list.length; i++) {
        mandatoryFieldListener("input", list[i]);
        setColor(document.getElementById(list[i]));
    }
}

function mandatoryFieldListener(type, elementId) {
    var element = document.getElementById(elementId);
    element.addEventListener(type, function () {
        setColor(element);
    });

}

function setColor(element) {
    if (isValid(element)) {
        element.style.borderColor = valid;
        element.style.backgroundColor = "white";
    }
    else {
        element.style.borderColor = invalid;
    }
}

function isValid(element) {
    if (element.id == 'password') {
        var email = document.getElementById('email').value;
        if (email !== "" && email !== document.getElementById('email').placeholder) {
            return element.value != undefined && element.value.length != 0;
        }
        else {
            return true;
        }
    }
    else {
        //checks to see if input is blank (not including placeholder)
        return element.value !== undefined && ($.trim(element.value).length > 0 || element.placeholder !== "") && (element.value.length == 0 || $.trim(element.value).length > 0);
    }
}

function allValid(list) {
    var i;
    for (i = 0; i < list.length; i++) {

        if (!isValid(document.getElementById(list[i]))) {
            return false;
        }
    }
    return true;
}

function highlightInvalidFields(list) {
    var i;
    for (i = 0; i < list.length; i++) {
        var element = document.getElementById(list[i]);
        if (!isValid(element)) {
            element.style.backgroundColor = "#ffd480";
        }
    }
}

