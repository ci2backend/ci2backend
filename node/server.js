var util = require('util');
var app = require('express')();
var http = require('http').Server(app);
var fs = require('fs');
var io = require('socket.io')(http);


var app_dir = "/var/www/only24h.com/node";


io.on('connection', function(socket) {
    console.log('a user connected');
    socket.on('notify_message', function(data) {
        console.log(data.name);
        console.log(data.message);
        // socket.broadcast.emit('message', data);
        io.sockets.emit('message', data);
    });
    // socket.on('disconnect', function() {
    //     console.log('user disconnected');
    // });
});


http.on('listening', function() {
    console.log('ok, server is running');
});

http.listen(8125, function() {

    console.log('listening on *:8125');

});

/* server started */
util.puts('Server running at http://127.0.0.1:8125/');
