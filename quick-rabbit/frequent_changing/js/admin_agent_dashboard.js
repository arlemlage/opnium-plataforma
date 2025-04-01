(function ($) {
  "use strict";
  //App Url
  let app_url = $('input[name="app-url"]').attr("data-app_url");
  let jqry = $.noConflict();
  setTableData();

  function setTableData() {
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

    let key = $(".ticket-btn-active").attr("data-key");

    jqry(`#dashboard_datatable_ticket`).DataTable({
      autoWidth: false,
      ordering: false,
      order: [[0, "desc"]],
      dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-12 col-lg-6 "i><"bottom-right-item col-12 col-lg-6 "p>',
      buttons: [
        {
          extend: "print",
          text: '<i class="fa fa-print"></i> Print',
          titleAttr: "print",
        },
        {
          extend: "copyHtml5",
          text: '<i class="fa fa-files-o"></i> Copy',
          titleAttr: "Copy",
        },
        {
          extend: "excelHtml5",
          text: '<i class="fa fa-file-excel-o"></i> Excel',
          titleAttr: "Excel",
        },
        {
          extend: "csvHtml5",
          text: '<i class="fa fa-file-text-o"></i> CSV',
          titleAttr: "CSV",
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fa fa-file-pdf-o"></i> PDF',
          titleAttr: "PDF",
        },
      ],
      language: {
        paginate: {
          previous: "Previous",
          next: "Next",
        },
      },
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + "/dashboard-tickets",
        type: "GET",
        dataType: "json",
        data: {
          key: key,
        },
      },
      columns: [
        { data: "ticket_id" },
        { data: "title" },
        { data: "product_category" },
        { data: "customer" },
        { data: "created_at" },
        { data: "updated_at" },
        { data: "last_commented_by" },
        { data: "action" },
      ],
      initComplete: function () {
        $('#dashboard_datatable_ticket [data-bs-toggle="tooltip"]').tooltip();
      },
    });
  }

  $(document).on("click", ".open_p_code_modal", function (e) {
    e.preventDefault();
    $("#p_code_modal").modal("show");
  });

  $(document).on("click", ".close_p_code_modal", function (e) {
    e.preventDefault();
    $("#p_code_modal").modal("hide");
  });

  $(document).on("click", ".config-alert", function () {
    let setting_type = $(this).attr("data-id");
    axios.put(app_url + "/api/update-config/", { setting_type: setting_type });
  });
})(jQuery);
