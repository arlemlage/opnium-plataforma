(function($){
    "use strict";
    let key_hidden = $('.ticket-btn-active').attr('data-key');
    let auth_type = localStorage.getItem('auth_type');

    //App Url
    let app_url = $('input[name="app-url"]').attr('data-app_url');

    // Data table for ticket get
    let jqry = $.noConflict();
    jqry(document).ready(function () {
        "use strict";
        setTableData();
    });
    function setTableData(){

        //use for every report view
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth() + 1; //January is 0!
        let yyyy = today.getFullYear();

        if (dd < 10) {
            dd = "0" + dd;
        }

        if (mm < 10) {
            mm = "0" + mm;
        }

        //get title and datatable id name from hidden input filed that is before in the table in view page for every datatable
        let datatable_name = $(".datatable_name").attr("data-id_name");
        //all of data from hidden fields
        let key = $('.ticket-btn-active').attr('data-key');
        let email_hidden = $("#email_hidden").val();
        let customer_id_hidden = $("#customer_id_hidden").val();
        let agent_id_hidden = $("#agent_id_hidden").val();
        let purchase_code_hidden = $("#purchase_code_hidden").val();
        let ajax_datatable_url = $("#ajax_datatable_url").val();
        let full_text_search = $("#full_text_search").val();
        let product_category_id_hidden = $('#product_category_id_hidden').val();
        let department_id_hidden = $('#department_id_hidden').val();
        let columns =[];
        let Print = $("#str_Print").val(); 
        let Copy = $("#str_Copy").val(); 
        let Excel = $("#str_Excel").val(); 
        let CSV = $("#str_CSV").val(); 
        let PDF = $("#str_PDF").val(); 
        let Previous = $("#str_Previous").val(); 
        let Next = $("#str_Next").val(); 

        if(auth_type == 'Customer') {
            columns = [
                { data: 'ticket_number' },
                { data: 'title' },
                { data: 'product_category' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'last_commented_by' },
                { data: 'status' },
                { data: 'action' },
            ]
        } else {
            columns = [
                { data: 'ticket_number' },
                { data: 'title' },
                { data: 'product_category' },
                { data: 'customer' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'last_commented_by' },
                { data: 'flag' },
                { data: 'status' },
                { data: 'action' },
            ]
        }
        jqry(`#datatable_ticket`).DataTable({
          autoWidth: false,
          ordering: false,
          order: [[0, "desc"]],
          dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-12 col-lg-6 "i><"bottom-right-item col-12 col-lg-6 "p>',
          buttons: [
            {
              extend: "print",
              text: '<i class="fa fa-print"></i> ' + Print,
              titleAttr: "print",
            },
            {
              extend: "copyHtml5",
              text: '<i class="fa fa-files-o"></i> ' + Copy,
              titleAttr: "Copy",
            },
            {
              extend: "excelHtml5",
              text: '<i class="fa fa-file-excel-o"></i> ' + Excel,
              titleAttr: "Excel",
            },
            {
              extend: "csvHtml5",
              text: '<i class="fa fa-file-text-o"></i> ' + CSV,
              titleAttr: "CSV",
            },
            {
              extend: "pdfHtml5",
              text: '<i class="fa fa-file-pdf-o"></i> ' + PDF,
              titleAttr: "PDF",
            },
          ],
          language: {
            paginate: {
              previous: Previous,
              next: Next,
            },
          },
          processing: true,
          serverSide: true,
          ajax: {
            url: ajax_datatable_url,
            type: "GET",
            dataType: "json",
            data: {
              key: key,
              email: email_hidden,
              customer_id: customer_id_hidden,
              agent_id: agent_id_hidden,
              purchase_code: purchase_code_hidden,
              product_category_id: product_category_id_hidden,
              department_id: department_id_hidden,
              full_text_search: full_text_search,
            },
          },
          columns: columns,
          initComplete: function () {
            $('#datatable_ticket [data-bs-toggle="tooltip"]').tooltip();
          },
        });
    }

    $(document).on('click', '.get_data', function(e) {
        e.preventDefault();
        $(".get_data").removeClass("ticket-btn-active");
        $(this).addClass("ticket-btn-active");

        let key_hidden = $(this).attr("data-key");
        setTableData(key_hidden);
    });


    $(document).on('click', '.open_p_code_modal', function(e) {
        $('#p_code_modal').modal('show');
    });

    $(document).on('click', '.close_p_code_modal', function(e) {
        $('#p_code_modal').modal('hide');
    });

    //search full text
    $(document).on('keyup', '#full_text_search', function (){
        let title_val = $(this).val();
        if (title_val && (title_val.length > 2)){
            let form_data = {
                key: $(this).val(),
            };
            let url = app_url+'/ticket-title-search';
            $.ajax({
                url: url,
                type: 'GET',
                data: form_data,
                success: function(data){
                    $('.results').empty();
                    if (data.result){
                        $('.results').append(data.result);
                        $('.results').removeClass('d-none');
                    }
                }
            });
        }
        else {
            $('.results').empty();
            $('.results').addClass('d-none');
        }
    });

    $(document).on('click', 'body', function (){
        $('.results').empty();
    });
        setTimeout(function(){$("#datatable_ticket_filter").hide();},2000);
})(jQuery);
