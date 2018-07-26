// var server = require('http').Server();

// var io = require('socket.io')(server);

// var Redis = require('ioredis');
// var redis = new Redis();

// redis.subscribe('orderbooks-channel');


// redis.on('message', function(channel, message) {
//    message = JSON.parse(message);

//    io.emit(channel + ':' + message.event, message.data);
//    console.log(channel, message);


// });

// server.listen(3000, function() {
//     console.log('Server is running on port 3000!');
// });

var fs = require('fs');
// This line is from the Node.js HTTPS documentation.
var options = {
    key: fs.readFileSync('/etc/nginx/ssl/socketliveprice.cryptovationx.io/385991/server.key'),
    cert: fs.readFileSync('/etc/nginx/ssl/socketliveprice.cryptovationx.io/385991/server.crt')
};
var app = require('https').createServer(options, handler);
var io = require('socket.io')(app);

var Redis = require('ioredis');
var redis = new Redis();
// var redis = new Redis({
//     port: 6379,          // Redis port
//     host: '167.99.72.182',   // Redis host
//     password: '82b7ce1c4569346f9db0d96c2db8750662cd24493b765765087422f866714ec8',
//   })

app.listen(8443, function() {
    console.log('Server is running on port 8443!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', function(socket) {
    //
});

redis.psubscribe('*', function(err, count) {
    //
});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});