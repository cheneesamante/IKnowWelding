/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Chat {

    constructor() {
        this.instanse = false;
        this.state = "";
        this.mes = "";
        this.file = "";
    }
    //gets the state of the chat
    getStateOfChat() {
        var self = this;
        var instanse = self.instanse;
        if (!instanse) {
            instanse = true;
            $.ajax({
                type: "POST",
                url: "common/personal_messages/process",
                data: {
                    'function': 'getState',
                    'file': self.file
                },
                dataType: "json",
                success: function (data) {
                    self.state = data.state;
                    self.instanse = false;
                },
            });
        }
    }
    //Updates the chat
    updateChat() {
        var self = this;
        var instanse = self.instanse;
        if (!instanse) {
            instanse = true;
            $.ajax({
                type: "POST",
                url: "common/personal_messages/process",
                data: {
                    'function': 'update',
                    'state': self.state,
                    'file': self.file
                },
                dataType: "json",
                success: function (data) {
                    if (data.text) {
                        for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>" + data.text[i] + "</p>"));
                        }
                    }
                    document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                    self.instanse = false;
                    self.state = data.state;
                },
            });
        } else {
            setTimeout(updateChat, 1500);
        }
    }
//send the message
    sendChat(message, nickname)
    {
        var self = this;
        self.updateChat();
        $.ajax({
            type: "POST",
            url: "common/personal_messages/process",
            data: {
                'function': 'send',
                'message': message,
                'nickname': nickname,
                'file': self.file
            },
            dataType: "json",
            success: function (data) {
                self.updateChat();
            },
        });
    }
}
