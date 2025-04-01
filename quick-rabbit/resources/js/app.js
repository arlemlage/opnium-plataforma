// we skiped use strict mode due to global access
import Axios from 'axios';
import './bootstrap';
import {Howl, Howler} from 'howler';
import Push from 'push.js';

let base_url = localStorage.getItem('base_url');
let user_ip = getUserIp();
let pusher_info = require('/assets/json/pusher.json');
let auth_id = localStorage.getItem('auth_id');
let auth_type = localStorage.getItem('auth_type');
let chat_sound = localStorage.getItem('chat_sound');
let browser_push = localStorage.getItem('browser_push');


let sound_1 = new Howl({
    src: [base_url+"/assets/media/click.mp3"],
    autoplay: false,
    loop: false,
    html5: true,
    volume: 0.5,
    muted: true,
    onend: function() {
        console.log("Finished!") //For debugging
    }
});

let sound_2 = new Howl({
    src: [base_url+"/assets/media/bip.mp3"],
    autoplay: false,
    loop: false,
    html5: true,
    volume: 0.5,
    muted: true,
    onend: function() {
        console.log("Finished!") //For debugging
    }
});

// Single chat part
$(document).on('click','.single-chat-message-send-btn_'+auth_id,function (e){
    e.preventDefault();
    let to_id = $('#to_id').val();
    let message = $('.single-chat-input_'+auth_id).val();
    let push_div = '';
    let message_div = '';
    let pair_key = auth_id+'_'+to_id;
    let message_time = time();

    if(validURL(message)) {
        let valid_url = fetchValidUrl(message);
        message_div = `<a target="_blank" href="${valid_url}" id="message_${message_time}"><i class="bi bi-check2-all receiver-status-icon d-none"></i>${valid_url}</a>`;
    } else {
        message_div = `<p id="message_${message_time}"><i class="bi bi-check2-all receiver-status-icon d-none"></i>${message}</p>`;
    }

    push_div = `<div class="receiver-data">
        <div class="c-pull-right">
        <div class="receiver-info">
        ${message_div} 
        </div>
        <div class="receiver-avater">
            <div class="receiver-time">
            <span>${currentTime()}</span>
            </div>
        </div>
        </div>
    </div>`;

    $('.single-chat-users_'+auth_id).prepend($(".single-pair-class_"+pair_key)).animate('slow'); // Push last message to top
    $('.single-chat-last-message_'+pair_key).text(message.substring(0,13)); // Add last message and css
    $('#single-chat-message-push-div_'+pair_key).append(push_div);
    $('#single-chat-messages_'+pair_key).scrollTop($('#single-chat-messages_'+pair_key)[0].scrollHeight);
    $('.single-chat-input_'+auth_id).val("");

    Axios.post(base_url+'/chat/send-single-chat-message',{
        to_id: to_id,
        message: message,
    }).then((response) => {
        if(response.data.status == false) {
            let target = 'message_'+message_time;
            $('#'+target).addClass("text-line-throw");
            $('<span class="color-red">Message not sent!</span>').insertAfter('#'+target);
        }
    });
});

// Listen single chat event
window.Echo.channel(pusher_info.channel_name).listen('.single-chat',(response) => {
    if(response.receiver.id == auth_id) {
        let push_div = '';
        let message_div = '';
        let pair_key = '';
        // Find message div
        if(response.message.is_link) {
            message_div = '<a target="_blank" href="'+response.message.text+'">'+response.message.text+'</a>';
        } else {
            message_div = '<p>'+response.message.text+'</p>';
        }

    
        push_div = '<div class="sender-data">'+
            '<div class="c-pull-left">'+
                '<div class="sender-info">'+
                message_div+
              '</div>'+
              '<div class="sender-avater">'+
                '<img title=' + '"' + response.sender.name + '"' + 'src=' + '"' + base_url+'/'+response.sender.image+'">'+
                '<div class="sender-time">'+
                  '<span>'+response.message.message_time+'</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
        '</div>';
        pair_key = auth_id+'_'+response.sender.id;
         // Find pair id to handle conflict
        plusUnseenMessage(response.receiver.id);

        $('.single-chat-users_'+auth_id).prepend($(".single-pair-class_"+pair_key)).animate('slow'); // Push last message to top
        let last_message = response.message.is_file ? "An attachment" : response.message.text;
        $('.single-chat-last-message_'+pair_key).text(last_message.substring(0,100)).addClass('text-unseen').removeClass('text-seen'); // Add last message and css
        $('#single-chat-message-push-div_'+pair_key).append(push_div);
        $('#single-chat-messages_'+pair_key).scrollTop($('#single-chat-messages_'+pair_key)[0].scrollHeight);

    }
});

// Update Single chat status
$(document).on('click','.single-chat-input_'+auth_id,function (event){
    let to_id = $(this).attr('data-to');
    let target = 'single-chat-last-message_'+auth_id+'_'+to_id;
    $('.'+target).addClass('text-seen').removeClass('text-unseen');
    Axios.get(base_url+'/chat/update-single-message-status/',{
        params: {
            to_id: to_id,
            status: 1
        }
    }).then((response) => {
        let current_value = $('.user-unseen_'+auth_id).text();
        let total_update = response.data.total;
        if(current_value > 0) {
            $('.user-unseen_'+auth_id).text(parseInt(current_value) - parseInt(total_update));
        } else {
            $('.user-unseen_'+auth_id).text(0);
        }
    });
});

// Update group chat status
$(document).on('click','.group-chat-input_'+auth_id,function (event){
    let group_id = $(this).attr('data-to');
    updateGroupMessageSeenStatus(group_id);
});

$(document).on('keypress','.single-chat-input_'+auth_id,function(event) {
    let to_id = $(this).attr('data-to');
    Axios.get(base_url+'/chat/update-single-message-status/',{
        params: {
            to_id: to_id,
            status: 1
        }
    });
    if(event.which == 13) {
        $('.single-chat-message-send-btn_'+auth_id).click();
    }
});


// Group chat part
$(document).on('keypress','.group-chat-input_'+auth_id,function(event) {
    if(event.which == 13) {
        $('.group-chat-message-send-btn_'+auth_id).click();
    }
});

$(document).on('click','.group-chat-message-send-btn_'+auth_id,function (e){
    e.preventDefault();
    let group_id = $('#group_id').val();
    let pair_key = auth_id+'_'+group_id;
    let message = $('.group-chat-input_'+auth_id).val();
    let message_div = '';
    let push_div = '';
    let message_time = time();
    if(validURL(message)) {
        let valid_url = fetchValidUrl(message);
        message_div = `<a target="_blank" href="${valid_url}" id="message_${message_time}"><i class="bi bi-check2-all receiver-status-icon d-none"></i>${valid_url}</a>`;
    } else {
        message_div = `<p id="message_${message_time}"><i class="bi bi-check2-all receiver-status-icon d-none"></i>${message}</p>`;
    }
    push_div = `<div class="receiver-data">
            <div class="c-pull-right">
            <div class="receiver-info">
            
                ${message_div} 
            </div>
            <div class="receiver-avater">
                <div class="receiver-time">
                <span>${currentTime()}</span>
                </div>
            </div>
            </div>
        </div>`;

    $('.group-chat-input_'+auth_id).val("");
    $('#group-chat-messages-push-div_'+pair_key).append(push_div);
    $('.group-chat-users_'+auth_id).prepend($(".group-pair-class_"+pair_key)).animate('slow'); // Push last message to top
    $('.group-chat-last-message_'+pair_key).text(message.substring(0, 13)).addClass('text-seen').removeClass("text-unseen"); // Add last message and css
    $('#group-chat-messages_'+pair_key).scrollTop($('#group-chat-messages_'+pair_key)[0].scrollHeight);

    Axios.post(base_url+'/chat/send-group-chat-message',{
        group_id: group_id,
        message: message,
    }).then((response) => {
        if(response.data.status == false) {
            let target = 'message_'+message_time;
            $('#'+target).addClass("text-line-throw");
            $('<span class="color-red">Message not sent!</span>').insertAfter('#'+target);
        }
    });
});

// Listen group chat event
window.Echo.channel(pusher_info.channel_name).listen('.group-chat',(response) => {
    if(response.sender.id != auth_id) {
        let push_div = '';
        let message_div = '';
        let auth_user_id = auth_id;
        let group_id = response.group.id;
        let pair_key = auth_user_id+'_'+group_id;

        if(response.message.is_link) {
            message_div = '<a target="_blank" href="'+response.message.text+'">'+response.message.text+'</a>';
        } else {
            message_div = '<p>'+response.message.text+'</p>';
        }

        push_div = '<div class="sender-data">'+
            '<div class="c-pull-left">'+
                '<div class="sender-info">'+
                    message_div+
                    '</div>'+
                    '<div class="sender-avater">'+
                    '<img title=' + '"' + response.sender.name + '"' + 'src=' + '"' + base_url+'/'+response.sender.image+'">'+
                    '<div class="sender-time">'+
                        '<span>'+response.message.message_time+'</span>'+
                    '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';

        plusUnseenMessage(response.group.receiver_id);
        
        $('#group-chat-messages-push-div_'+pair_key).append(push_div);
        $('.group-chat-users_'+auth_id).prepend($(".group-pair-class_"+pair_key)).animate('slow'); // Push last message to top
        let last_message = response.message.is_file ? "An attachment" : response.message.text;
        $('.group-chat-last-message_'+pair_key).text(last_message.substring(0, 13)).addClass('text-unseen'); // Add last message and css
        $('#group-chat-messages_'+pair_key).scrollTop($('#group-chat-messages_'+pair_key)[0].scrollHeight);
    }
});


// Send message to agent from frontend
$(document).on('keypress','#message-box_'+user_ip,function(event) {
    $('#message-box_'+user_ip).css('border','1px solid rgb(206, 212, 218)');
    if(event.which == 13) {
        $('#customer-send-message_'+user_ip).click();
    }
});

$(document).on('click','#message-box_'+user_ip,function(event) {
    let group_id  = $(this).attr('data-id');
    if(group_id != undefined) {
        updateSeenStatusFromGuest(group_id);
    }
    
    $('#message-box_'+user_ip).css('border','1px solid rgb(206, 212, 218)');
    if(event.which == 13) {
        $('#customer-send-message_'+user_ip).click();
    }
});

 $(document).on('click','#customer-send-message_'+user_ip,function() {
    let guest_name = $('#guest-user-name_'+user_ip).val();
    let guest_email = $('#guest-user-email_'+user_ip).val();
    let message = $('#message-box_'+user_ip).val();
    let product_id = $('#category-box_'+user_ip).val();

    if(product_id == undefined) {
        product_id = $('#selected-product_'+user_ip).val();
    }
    if(guest_name == undefined) {
        guest_name = $('#selected-guest-name_'+user_ip).val();
    }
    if(guest_email == undefined) {
        guest_email = $('#selected-guest-email_'+user_ip).val();
    }

    if(!guest_name.length && guest_name.trim() == "") {
        $('#guest-user-name_'+user_ip).addClass("is-invalid").css('border','1px solid red !important;');
       return false;
    } else if(!guest_email.length && guest_email.trim() == "") {
        $('#guest-user-email_'+user_ip).addClass("is-invalid").css('border','1px solid red !important;');
       return false;
    } else if(! ValidateEmail(guest_email)){
        $('#guest-user-email_'+user_ip).addClass("is-invalid").css('border','1px solid red !important;');
        return false;
    } else if(!product_id.length || product_id == 0) {
        $('.category-box-'+user_ip).trigger('click');
       return false;
    } else if(!(message.length) && (message.trim() == "")) {
        $('#message-box_'+user_ip).addClass("is-invalid").css('border','1px solid red !important;');
        return false;
    }  else {
        let message_from = 'guest'
        let sender_message = '';
        let message_time = time();
        if(validURL(message)) {
            let valid_url = fetchValidUrl(message);
            sender_message = `<div class="user-chat d-flex">
                <div class="read-status delivered"></div>
                <div class="chat-text">
                    <span><span id="message_${message_time}"><a target="_blank" href="${valid_url}" >${valid_url}</a></span></span>
                </div>
            </div>`;
        } else {
            sender_message = `<div class="user-chat d-flex">
                <div class="read-status delivered"></div>
                <div class="chat-text">
                    <span><span id="message_${message_time}">${message}</span></span>
                </div>
            </div>`;
        }
        $('.category-box-'+user_ip).addClass('d-none');
        $('#guest-user-name_'+user_ip).addClass('d-none');
        $('#guest-user-email_'+user_ip).addClass('d-none');

        $('#gust-chat-message_'+user_ip).addClass('trigger_to_large').removeClass('trigger_to_small');
        $('#message-box_'+user_ip).val('');
        $('#gust-chat-message_'+user_ip).append(sender_message).scrollTop($('#gust-chat-message_'+user_ip)[0].scrollHeight);

         Axios.post(base_url+'/send-message',{
            guest_user_name: guest_name,
            guest_user_email: guest_email,
            message: message,
            product_id: product_id,
            message_from: message_from
        }).then((response) => {
            $('#guest-product_'+user_ip).text(response.data.product);
            $('#guest-'+user_ip).removeClass('d-none').load(location.href + " #guest-"+user_ip);
            $('#message-box_'+user_ip).attr('data-id',response.data.group_id);
            $('#selected-product_'+user_ip).val(response.data.product_id);
            $('#selected-guest-name_'+user_ip).val(guest_name);
            $('#selected-guest-email_'+user_ip).val(guest_email);
            if(response.data.status == false) {
                let target = 'message_'+message_time;
                $('#'+target).addClass("text-line-throw");
                $('<span class="color-red">Message not sent!</span>').insertAfter('#'+target);
            }
        });
    }
});

 
// Admin Push notification part
if(auth_type === "Admin") {
    window.Echo.channel(pusher_info.channel_name).listen('.admin-notification',(response) => {
       if(auth_type === "Admin") {
            callNotification(response.message);
       }
    });
}

// Agent Push notification part
if (auth_type === "Agent") {
    window.Echo.channel(pusher_info.channel_name).listen('.agent-notification',(response) => {   
       if(response.agent_for.includes(auth_id)) {
            callNotification(response.message);
       }
    });
}

// Customer Push notification part
if(auth_type === "Customer") {
   window.Echo.channel(pusher_info.channel_name).listen('.customer-notification',(response) => {
       if(response.customer_for === auth_id && auth_type === "Customer") {
            callNotification(response.message);
       }
    });
}

window.Echo.channel(pusher_info.channel_name).listen('.guest-message',(response) => {
    if(response.group.created_by == user_ip) {
        $('#agent-name_'+user_ip).text(response.sender.name);
        $('#agent-photo').attr('src',base_url+'/'+response.sender.image);
        let agent_image = base_url + "/" + "response.sender.image";
        let message_div = '';
        if(response.message.is_link) {
            message_div = `<div class="agent-chat d-flex">
                <div class="chat-text">
                <img src="${agent_image}" alt="" id="agent-photo">
                    <span>
                        <span><a target="_blank" href="${response.message.text}">${response.message.text}</a></span>
                    </span>
                </div>
            </div>`;
        
        }  else {
            message_div = `<div class="agent-chat d-flex">
                <div class="chat-text">
                <img src="${agent_image}" alt="" id="agent-photo">
                    <span>
                        <span>${response.message.text}</span>
                    </span>
                </div>
            </div>`;
        }   
        
        $('#gust-chat-message_'+user_ip).append(message_div).scrollTop($('#gust-chat-message_'+user_ip)[0].scrollHeight);
        sound_1.play();
    }
    
});

// Browser push notification with npm puser if need
window.Echo.channel(pusher_info.channel_name).listen('.browser-push',(response) => {
    if(browser_push == "Yes") {
        if(response.browser_id == getUserIp()) {
            const iconPath = $('#site_logo').val();
            Push.create(response.title,{
                body: response.message,
                timeout: 5000,
                icon: iconPath
            });
        }
    }
});

window.Echo.channel(pusher_info.channel_name).listen('.make-seen',(response) => {
    if(response.type == "group") {
        $('.individual-group_'+response.for).find('.receiver-status-icon').removeClass('d-none').addClass('receiver-status-seen');
    } else if(response.type == "guest") {
        $('#gust-chat-message_'+response.for).find('.read-status').removeClass('delivered').addClass('seen');
    } else if(response.type == "single") {
        $('.single-message-for_'+response.for).find('.receiver-status-icon').removeClass('d-none').addClass('receiver-status-seen');
    }
 });

 function updateGroupMessageSeenStatus(group_id) {
    let target = 'group-chat-last-message_'+auth_id+'_'+group_id;
    $('.'+target).addClass('text-seen').removeClass('text-unseen');
    Axios.get(base_url+'/chat/update-group-message-status',{
        params: {
            group_id: group_id,
            status: 1
        }
    }).then((response) => {
        let current_value = $('.user-unseen_'+auth_id).text();
        let total_update = response.data.total;
        if(response.data.status == true) {
            let current_text_count = parseInt(current_value) - parseInt(total_update);
            if(current_text_count < 0) {
                $('.user-unseen_'+auth_id).text(0);
            } else {
                $('.user-unseen_'+auth_id).text(current_text_count);
            }
        }
    });
 }

 function updateSeenStatusFromGuest(group_id) {
    $.ajax({
        url: base_url+'/update-seen-status-from-guest',
        data: {
            group_id: group_id,
        },
        method: "GET"
    });
 }


function plusUnseenMessage(target_user_id) {
    const current_value = $('.user-unseen_'+target_user_id).text();
    $('.user-unseen_'+target_user_id).text(parseInt(current_value) + 1);
    if(target_user_id == auth_id) {
        sound_1.play();
    }
}


// Call notification
function callNotification(text){
    sound_2.play();
    toastr.options.positionClass = 'toast-top-right';
    toastr.success(text);
    let notification_div = $('.user-notification_'+auth_id);
    let current_count = parseInt(notification_div.text());
    if(current_count===99 || current_count>99){
        notification_div.text("99+");
    }else{
        notification_div.text(parseInt(notification_div.text()) + 1);
    }
    
}


// Get client ip address
function getUserIp() {
    let original_ip = localStorage.getItem('user_ip');
    return original_ip;
}

function validURL(str) {
  let pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}

function currentTime() {
    let date = new Date(); // for now
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

function time() {
    var timestamp = Math.floor(new Date().getTime() / 1000)
    return timestamp;
}

function ValidateEmail(email){
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(email.match(mailformat)){
            return true;
    } else{
            return false;
    }
}

function fetchValidUrl(message) {
    let valid_url = '';
    $.ajax({
        url: base_url+'/api/make-valid-url',
        method: 'POST',
        async: false,
        data: {
            message: message
        },
        success: function (response) {
            valid_url = response
        }
    });
    return valid_url;
}


 // FCM
 // Import firebase data from json file

let firebase_info = require('/assets/json/firebase.json');
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getMessaging, getToken, onMessage  } from "firebase/messaging";
import 'firebase/database'; // If using Firebase database
import 'firebase/storage';  // If using Firebase storage

const firebaseConfig = {
  apiKey: firebase_info.api_key,
  authDomain: firebase_info.auth_domain,
  databaseURL: firebase_info.database_url,
  projectId: firebase_info.project_id,
  storageBucket: firebase_info.storage_bucket,
  messagingSenderId: firebase_info.messaging_sender_id,
  appId: firebase_info.app_id,
  measurementId: firebase_info.measurement_id
};

const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

const messaging = getMessaging();

getToken(messaging, firebase_info.key_pair).then((currentToken) => {
  if (currentToken) {
    Axios.post(base_url+'/store-token',{
        token: currentToken
    });
  }
}).catch((err) => {
  console.log('An error occurred while retrieving token. ', err);
  // ...
});


onMessage(messaging, (payload) => {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});















