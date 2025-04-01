$(function () {
    "use strict";
     let base_url = $('input[name="app-url"]').attr('data-app_url');
 
     $( document ).on('click','#allCheck', function() {
         $("input:checkbox.checkbox_notification").prop('checked', $(this).prop("checked"));
     });
    $(document).on('click','#mark_as_read',function () {
       axios.put(base_url+'/mark-as-read-all',{
           notification_ids: selectedNotificationId()
       }).then((response) => {
          if(response.data.status === true) {
              location.reload();
          }
       });
    });
 
    $(document).on("click", "#delete_all", function () {
      axios
        .delete(base_url + "/delete-all-notification", {
          params: {
            notification_ids: selectedNotificationId(),
          },
        })
        .then((response) => {
          if (response.data.status === true) {
            location.reload();
          }
        });
    });
 
    function selectedNotificationId() {
        let notification_id = [];
         $('.checkbox_notification').each(function(i,obj)  {
             if($(this).prop("checked") === true) {
                 notification_id.push($(this).val());
             }
         });
         return notification_id;
    }
 });
 