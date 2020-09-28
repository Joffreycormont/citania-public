// src/AppBundle/Resources/public/js/sf-websocket.js
/* globals wsUrl: true */


    'use strict';
  
    var _receiver = document.getElementById('ws-content-receiver');
    var ws = new WebSocket('ws://' + wsUrl);
  
    ws.onopen = function () {
      ws.send('Hello');
      _receiver.innerHTML = 'Connected !';
    };
  
    ws.onmessage = function (event) {
      _receiver.innerHTML = event.data;
    };
  
    ws.onclose = function () {
      _receiver.innerHTML = 'Connection closed';
    };
  
    ws.onerror = function () {
      _receiver.innerHTML = 'An error occured!';
    };



var defaultChannel = 'general';
var botName = 'ChatBot';

var addMessageToChannel = function(message) {
  _receiver.innerHTML += '<div class="message">' + message + '</div>';
};

var botMessageToGeneral = function (message) {
  return addMessageToChannel(JSON.stringify({
    action: 'message',
    channel: defaultChannel,
    user: botName,
    message: message
  }));
};

ws.onopen = function () {
  ws.send(JSON.stringify({
    action: 'subscribe',
    channel: defaultChannel,
    user: userName
  }));
};

ws.onmessage = function (event) {
  addMessageToChannel(event.data);
};

ws.onclose = function () {
  botMessageToGeneral('Connection closed');
};

ws.onerror = function () {
  botMessageToGeneral('An error occured!');
};

//var userName = prompt('Hi! I need your name for the Chat please :)');

var _textInput = document.getElementById('ws-content-to-send');
var _textSender = document.getElementById('ws-send-content');
var enterKeyCode = 13;

var sendTextInputContent = function () {
  // Get text input content
  var content = _textInput.value;

  // Send it to WS
  ws.send(JSON.stringify({
    action: 'message',
    user: userName,
    message: content,
    channel: 'general'
  }));

  // Reset input
  _textInput.value = '';
};

_textSender.onclick = sendTextInputContent;
_textInput.onkeyup = function(e) {
  // Check for Enter key
  if (e.keyCode === enterKeyCode) {
    sendTextInputContent();
  }
};