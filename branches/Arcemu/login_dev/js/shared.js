///////////////////////////////////
// Cookie Manipulation Functions //
///////////////////////////////////
function createCookie(name, value, hours, domain) {
    if (hours) {
        var date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
    }
    document.cookie = name +"="+ value +
                    ((hours) ? "; expires="+ date.toGMTString() : '') +
                    ((domain) ? "; domain="+ domain : '');
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}