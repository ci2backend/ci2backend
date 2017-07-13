$(document).ready(function() {

    var socket = io(node_server_url);

    socket.on('message', function(data) {
        alert("New message!\nName: " + data.name + "\nContent: " + data.message);
    });

})