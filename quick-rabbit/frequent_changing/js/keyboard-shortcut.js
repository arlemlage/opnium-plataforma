(function($){
    "use strict";
    $(document).on("keydown", function (e) {
        if (e.ctrlKey && e.altKey && e.keyCode == 82) {
            e.preventDefault();
            alert('r');
        }
        if (e.ctrlKey && e.altKey && e.keyCode == 77) {
            e.preventDefault();
            alert('m');
        }
        if (e.ctrlKey && e.altKey && e.keyCode == 65) {
            e.preventDefault();
            alert('a');
        }
        if (e.ctrlKey && e.altKey && e.keyCode == 67) {
            e.preventDefault();
            alert('c');
        }
    });
})(jQuery);
