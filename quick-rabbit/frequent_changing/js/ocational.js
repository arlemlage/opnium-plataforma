"use strict";
$(".select2").select2();
$(".customDatepicker").datepicker({
  format: "yyyy-mm-dd",
  autoclose: true,
});
$(".customTimepicker").timepicker({
  timeFormat: "HH:mm:ss",
  interval: 15,
  defaultTime: "now",
  dynamic: false,
  dropdown: true,
  scrollbar: true,
});
