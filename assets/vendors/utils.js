/**
 * Created by Affan on 07/03/2018.
 */
(function ($) {
    "use strict";
    var escChar = [8, 13, 0];
    $('body').find('.input-number').keypress(function (e) {
        var txt = String.fromCharCode(e.which);
        if (!escChar.includes(e.which) && !txt.match(/[0-9\.]/)) {
            return false;
        }
    });
    $('body').find('.input-digit').keypress(function (e) {
        var txt = String.fromCharCode(e.which);
        if (!escChar.includes(e.which) && !txt.match(/[0-9#\/\\.]/)) {
            return false;
        }
    });
})(jQuery);

function formatDate(strDate) {
    var arrDate = strDate.split('-');
    if (arrDate.length === 3)
        return arrDate[2] + "-" + arrDate[1] + "-" + arrDate[0]
    else return strDate
}

// function isNumber(s) {
//     var pattern = /[0-9]|\./;
//     return pattern.test(s);
// }
//
// function isValidEmail(s) {
//     var pattern = /^([\w\.-])@([\w\.-])\.([\w\.-])$/;
//     return pattern.test(s);
// }
//
// function keypressToStr(event) {
//     var e = event | window.event;
//     var k = e.keyCode | e.which;
//     alert(String.fromCharCode(k)+"a");
//     return String.fromCharCode(k);
// }
//
// function acceptNumber(event) {
//     if(isNumber(keypressToStr(event)))
//         return false;
// }
//
// function validateEmail(event) {
//     var email = keypressToStr(event);
//     console.log(event);
// }