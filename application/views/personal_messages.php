<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-min.js"></script> 
<script type="text/javascript" src="<?php echo JS_PATH; ?>chat/Chat.js"></script>

<style type="text/css">
    *                               { margin: 0; padding: 0; }
    body                            { font: 12px "Lucida Grande", Sans-Serif; }
    h2                              { color: #fa9f00; font: 30px Helvetica, Sans-Serif; margin: 0 0 10px 0; }
    #page-wrap                      { width: 500px; margin: 30px auto; position: relative; }

    #chat-wrap                      { border: 1px solid #eee; margin: 0 0 15px 0; }
    #chat-area                      { height: 300px; overflow: auto; border: 1px solid #666; padding: 20px; background: white; }
    #chat-area span                 { color: white; background: #333; padding: 4px 8px; -moz-border-radius: 5px; -webkit-border-radius: 8px; margin: 0 5px 0 0; }
    #chat-area p                    { padding: 8px 0; border-bottom: 1px solid #ccc; }

    #name-area                      { position: absolute; top: 12px; right: 0; color: white; font: bold 12px "Lucida Grande", Sans-Serif; text-align: right; }   
    #name-area span                 { color: #fa9f00; }

    #send-message-area p            { float: left; color: white; padding-top: 27px; font-size: 14px; }
    #sendie                         { border: 3px solid #999; width: 360px; padding: 10px; font: 12px "Lucida Grande", Sans-Serif; float: right; }
</style>
<script>
    // display name on page
    var name = "Test";
    $("#name-area").html("You are: <span>" + name + "</span>");
    var chat = new Chat();
    $(document).ready(function () {
        chat.getStateOfChat();
        // watch textarea for key presses
        $("#sendie").keydown(function (event) {

            var key = event.which;

            //all keys including return.  
            if (key >= 33) {

                var maxLength = $(this).attr("maxlength");
                var length = this.value.length;

                // don't allow new content if length is maxed out
                if (length >= maxLength) {
                    event.preventDefault();
                }
            }
        });
        // watch textarea for release of key press
        $('#sendie').keyup(function (e) {

            if (e.keyCode == 13) {

                var text = $(this).val();
                var maxLength = $(this).attr("maxlength");
                var length = text.length;

                // send 
                if (length <= maxLength + 1) {
                    chat.sendChat(text, name);
                    $(this).val("");
                } else {
                    $(this).val(text.substring(0, maxLength));
                }


            }
        });
    });

</script>


<!-- content starts -->
<!-- insert the page content here -->
<h2>Messages</h2>
<!--setInterval('chat.updateChat()', 1000) -->
<body onload="">

    <div id="page-wrap">

        <h2>jQuery/PHP Chat</h2>

        <p id="name-area"></p>

        <div id="chat-wrap"><div id="chat-area"></div></div>

        <form id="send-message-area">
            <p>Your message: </p>
            <textarea id="sendie" maxlength = '100' ></textarea>
        </form>

    </div>

</body>

