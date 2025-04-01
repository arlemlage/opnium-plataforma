"use strict";
// we skiped use strict mode due to global access
$(".customTimepicker").timepicker({
  timeFormat: "HH:mm:ss",
  interval: 15,
  defaultTime: "now",
  dynamic: false,
  dropdown: true,
  scrollbar: true,
});
