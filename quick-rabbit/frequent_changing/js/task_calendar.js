(function($){
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');
        function customEventData() {
            let eventData = [];
             $.ajax({
                method: 'GET',
                url: base_url+"/api/task-lists",
                async: false,
                success: function(response){
                    $.each(response, function (i, data) {
                        $('.fc-content').css('margin-top','5px');
                        eventData.push({
                            id: data.id,
                            title: data.task_title,
                            start:  data.work_date,
                            backgroundColor: data.bg_color,
                            textColor: data.status == "In-Progress" ? 'black' : 'white',
                            borderColor: data.bg_color
                        });
                    });
                }
            });
             return eventData;
        }
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('task-calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listYear'
            },
            displayEventTime: false,
            editable: true,
            events : customEventData(),
            eventClick: function(event) {
                let task_id = event.event.id;
                let type = event.event.extendedProps.type;
                let event_title = event.event.title;
                axios.get(base_url+'/api/task-status-change-form/'+task_id,{
                    params:{
                        type: type
                    }
                }).then(function (response) {
                    $('#task-edit-modal').modal('show');
                    $('#task-edit-modal-title').html(event_title);
                    $('#task-edit-modal-body').html(response.data);
                });
            },
            dateClick: function(event) {
                let assign_date = event.dateStr;
                axios.get(base_url+'/api/date-wise-tasks/'+assign_date).then(function (response) {
                    $('#task-details').modal('show');
                    $('#task-details-modal-title').html("Task list on "+assign_date);
                    $('#task-details-modal-body').html(response.data);
                });
            },
            
        });
        calendar.render();
      });
        $(document).on('click','.td_close_modal',function() {
           $('#task-details').modal('hide');
        });
        $(document).on('click','.te_close_modal',function() {
           $('#task-edit-modal').modal('hide');
        })
    })(jQuery);