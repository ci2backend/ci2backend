$(document).ready(function() {

    var socket = io(node_server_url);

    $('#form_contact').submit(function() {
        var email = $('#contact_name').val();
        var message = $('#message').val();
        socket.emit('notify_message', {
            name: email,
            message: message
        });
        $('form input').val('');
        $('#message').val('');
        return false;
    });

})