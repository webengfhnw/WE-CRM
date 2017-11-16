/**
 * Created by andreas.martin on 17.11.2016.
 */

let serviceEndpointURL = window.location.protocol + "//" + window.location.host + window.location.pathname.substr(0, window.location.pathname.indexOf("stage16")) +"stage15/api";

function getToken(email, password, callback) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Basic " + btoa(email + ":" + password)
        },
        url: serviceEndpointURL + "/token",
        success: function (data, textStatus, response) {
            localStorage.setItem("token", response.getResponseHeader("Authorization"));
            callback(true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
            callback(false);
        }
    });
}

function validateToken(callback) {
    $.ajax({
        type: "HEAD",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
        url: serviceEndpointURL + "/token",
        success: function (data, textStatus, response) {
            callback(true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            callback(false);
        }
    });
}

function removeTokenLocal() {
    localStorage.removeItem("token");
}

function postCustomer(customer, callback) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
        url: serviceEndpointURL + "/customer",
        data: customer,
        success: function (data, textStatus, response) {
            console.log(textStatus);
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function getCustomer(customerID, callback) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
        dataType: "json",
        url: serviceEndpointURL + "/customer/" + customerID,
        success: function (data, textStatus, response) {
            console.log(textStatus);
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function getCustomers(callback) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
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
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
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
    $.ajax({
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
        url: serviceEndpointURL + "/customer/" + customerID,
        success: function (data, textStatus, response) {
            console.log(textStatus);
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
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
