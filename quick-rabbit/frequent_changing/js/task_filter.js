(function($){
    "use strict";
    let base_url = $('meta[name="base-url"]').attr('base_url');

    // Filter tasks
    $(document).on("click","#filter-task",function (event) {
       let from_filter = $('#from_filter').val();
       let assign_date = $('#assign_date').val();
       let project_id = $('#project_id').val();
       let assigned_to = $('#assigned_to').val();
       axios.post(base_url+'/user/bt-date-wise-tasks/'+assign_date,{
           from_filter: from_filter,
           project_id: project_id,
           assigned_to: assigned_to
       }).then((response) => {
          console.log(response);
          $('#calendar-task-loop').empty().html(response.data);
       });
    });
})(jQuery);
