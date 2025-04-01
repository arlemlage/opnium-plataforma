(function($){
    "use strict";

    let allVacations = $('.allVacations').val();
    document.addEventListener('DOMContentLoaded', function() {
    let initialLocaleCode = 'en';
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        initialDate: new Date(),
        locale: initialLocaleCode,
        buttonIcons: true, // show the prev/next text
        weekNumbers: false,
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events
        events: jQuery.parseJSON(allVacations),
    });
    calendar.render();
});

})(jQuery);
