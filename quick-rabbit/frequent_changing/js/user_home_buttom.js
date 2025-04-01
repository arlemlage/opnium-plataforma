"use strict";
// we skiped use strict mode due to global access
// material icon init
feather.replace();
let ir_precision_h = $("#ir_precision").val();
let window_height = $(window).height();
let main_header_height = $(".main-header").height();
let user_panel_height = $(".user-panel").height();
let left_menu_height_should_be = (
  parseFloat(window_height) -
  (parseFloat(main_header_height) + parseFloat(user_panel_height))
).toFixed(ir_precision_h);
left_menu_height_should_be = (
  parseFloat(left_menu_height_should_be) - parseFloat(60)
).toFixed(ir_precision_h);

base_url = $('meta[name="base-url"]').attr('base_url');
let csrf_name_ = $("#csrf_name_").val();
let csrf_value_ = $("#csrf_value_").val();
let not_closed_yet = $("#not_closed_yet").val();
let opening_balance = $("#opening_balance").val();
let customer_due_receive = $("#customer_due_receive").val();
let paid_amount = $("#paid_amount").val();
let in_ = $("#in_").val();
let cash = $("#cash").val();
let paypal = $("#paypal").val();
let sale = $("#sale").val();
let card = $("#card").val();
let register_not_open = $("#register_not_open").val();
let currency = "";

function IsJsonString(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

display_date_time();
function getNewDateTime() {
  let refresh = 1000; // Refresh rate in milli seconds
  setTimeout(display_date_time, refresh);
}
function display_date_time() {
  //for date and time
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
  let time_a = new Date().toLocaleTimeString();
  let today_date = yyyy + "-" + mm + "-" + dd;

  $("#closing_register_time").html(today_date + " " + time_a);
  /* recursive call for new time*/
  getNewDateTime();
}
