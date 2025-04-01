(function($){
    "use strict";
    $(".select2").select2();
    let app_url = $('input[name="app-url"]').attr('data-app_url');
    
    $(document).on('click','#task-update-button',function (event) {
        let status = $('#task-status').val();
        if(status == "") {
           $('#task-status').data("select2").open();
           return false;
        }
        let task_id = $('#task_id').val();
        if(task_id !== "") {
            axios.put(app_url+'/update-task-status/'+task_id,{
                status: status,
            }).then((response) => {
                window.location.href = response.data;
            })
        }
    });
})(jQuery);


