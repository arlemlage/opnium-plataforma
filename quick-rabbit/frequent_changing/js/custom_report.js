//pdf,print,export datatable
let jqry = $.noConflict();
jqry(document).ready(function () {
  "use strict";

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
  today = yyyy + "-" + mm + "-" + dd;

  //get title and datatable id name from hidden input filed that is before in the table in view page for every datatable
  let datatable_name = $(".datatable_name").attr("data-id_name");
  let title = $(".datatable_name").attr("data-title");
  let is_pagination = $(".is_pagination:last").val();
  if(is_pagination=="true"){
    is_pagination = true;
  }else{
    is_pagination = false;
  }
 
  let TITLE = title + ", " + today;
  jqry(`#${datatable_name},#datatable2`).DataTable({
    autoWidth: false,
    ordering: true,
    order: [[0, "desc"]],
    bPaginate:is_pagination,
    dom: '<"top-left-item "lf> <"top-right-item "B> t <"bottom-left-item  "i><"bottom-right-item col-sm-12 col-md-6 "p>',
    buttons: [
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Print',
        titleAttr: "print",
        exportOptions: {
          columns: ':not(:last-child)',
        }
      },
      {
        extend: "copyHtml5",
        text: '<i class="fa fa-files-o"></i> Copy',
        titleAttr: "Copy",
        exportOptions: {
          columns: ':not(:last-child)',
        }
      },
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        titleAttr: "Excel",
        exportOptions: {
          columns: ':not(:last-child)',
        }
      },
      {
        extend: "csvHtml5",
        text: '<i class="fa fa-file-text-o"></i> CSV',
        titleAttr: "CSV",
        exportOptions: {
          columns: ':not(:last-child)',
        }
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fa fa-file-pdf-o"></i> PDF',
        titleAttr: "PDF",
        exportOptions: {
          columns: ':not(:last-child)',
        }
      },
    ],
    language: {
      paginate: {
        previous: "Previous",
        next: "Next",
      },
    },
  });
});
