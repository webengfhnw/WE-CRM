/**
 * Created by andreas.martin on 17.11.2016.
 */

let serviceEndpointURL = window.location.protocol + "//" + window.location.host + window.location.pathname.substr(0, window.location.pathname.indexOf("stage16")) +"stage15/api";

function postCustomer(customer, callback) {
    /* TODO: write POST customer */
}

function getCustomer(customerID, callback) {
    /* TODO: write GET customer */
}

function getCustomers(callback) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: serviceEndpointURL + "/customer",
        success: function (data, textStatus, response) {
            console.log(textStatus);
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function putCustomer(customerID, data, callback) {

    $.ajax({
        type: "PUT",
        url: serviceEndpointURL + "/customer/" + customerID,
        data: data,
        success: function (data, textStatus, response) {
            console.log(textStatus);
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });

}

function deleteCustomer(customerID, callback) {
    /* TODO: write DELETE customer */
}

function getCustomerJSON(id, name, email, mobile) {
    if (id === null) {
        return JSON.stringify({
            "name": name,
            "email": email,
            "mobile": mobile
        });
    }
    return JSON.stringify({
        "id": id,
        "name": name,
        "email": email,
        "mobile": mobile
    });
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null;
}
