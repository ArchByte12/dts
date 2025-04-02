$(document).ready(function () {
    // generate tracking number
    $('#tracking_number').val(generateTrackingNumber());

    // validate tracking number
    $('#tracking_number').focusout(function () {
        var tracking_number = $('#tracking_number').val();
        if (validateTrackingNumber(tracking_number)) {
            $('#tracking_number').val(generateTrackingNumber());
        }
    });
});

// generate tracking_number format (YYYYMM-XXXXXX)
function generateTrackingNumber() {
    var date = new Date();
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var tracking_number = year + "" + month;
    var latestTrackingNumber = getLastTrackingNumber();
    // check if YYYYMM is the same as the latest tracking number
    if (latestTrackingNumber.substring(0, 6) === tracking_number) {
        var nextNumber = latestTrackingNumber.substring(7);
        tracking_number += nextNumberGenerator(nextNumber);
    } else {
        tracking_number += "0000001";
    }
    var nextNumber = nextNumberGenerator();
    if (validateTrackingNumber(tracking_number)) {
        tracking_number = generateTrackingNumber();
    }
    return tracking_number;
}

// validate to db if tracking number already exists
function validateTrackingNumber(tracking_number) {
    var result = false;
    $.ajax({
        url: 'conn/validation',
        type: 'POST',
        async: false,
        data: {
            tracking_number: tracking_number
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.status === "success") {
                result = false;
            } else {
                result = true;
            }
        }
    });
    return result;
}

// Next number generator
function nextNumberGenerator(nextNumber) {
    var nextNumber = parseInt(nextNumber) + 1;
    nextNumber = nextNumber.toString().padStart(7, '0');
    return nextNumber;
}

// get last tracking number to database
function getLastTrackingNumber() {
    var lastTrackingNumber = "";
    $.ajax({
        url: 'conn/validation',
        type: 'POST',
        async: false,
        data: {
            lastTrackingNumber: "latestTrackingNumber"
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.status === "success") {
                lastTrackingNumber = response.tracking_number;
            }
        }
    });
    return lastTrackingNumber;
}