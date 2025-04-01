(function ($) {
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');
    localStorage.setItem('base_url',app_url);
    let userId = $('.auth-user-id').val();
    localStorage.setItem('auth_id',userId);
    setCookie('auth_id', userId, 9000);
    let authType = $('.auth-user-type').val();
    localStorage.setItem('auth_type',authType);
    setCookie('auth_type', authType, 9000);
    let chatSound = $('.has-chat-sound').val();
    localStorage.setItem('chat_sound',chatSound);
    setCookie('chat_sound', chatSound, 9000);
    let browserPush = $('#has-browser-push').val();
    localStorage.setItem('browser_push',browserPush);
    setCookie('browser_push', browserPush, 9000);
    function setCookie(name,value,days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
})(jQuery);