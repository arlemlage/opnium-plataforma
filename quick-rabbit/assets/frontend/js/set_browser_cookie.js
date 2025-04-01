(function ($) {
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');
    localStorage.setItem('base_url',base_url);

    function makeid(length) {
        let result = '';
        const characters = '0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
          counter += 1;
        }
        return result;
    }
    
    let device_key = localStorage.getItem('user_ip');
    if(!device_key) {
        let unique_id = makeid(10);
        if(checkBrowserId(unique_id)) {
            unique_id = makeid(10);
        }
        localStorage.setItem('user_ip',makeid(10));
    }

    function checkBrowserId(unique_id) {
        let status = false;
        $.ajax({
            url: base_url+"/api/check-browser-id/"+unique_id,
            method: 'GET',
            async: false,
            success: function(response) {
                status = response;
            }
        })
        return status;
    }
    let userIp = localStorage.getItem('user_ip');
    setCookie('user_ip', userIp, 9000);

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