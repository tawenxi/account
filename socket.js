var server = require('http').Server();

var io = require('socket.io')(server);  //是一个发射器

var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('test-channel');

redis.on('message', function(channel, message) {
	message = JSON.parse(message);
	
	if (message.event == 'App\\Events\\UpdateData') {message = message.data.zfpz;}
	console.log(message);
	io.emit('updatenewpass',message);
});

server.listen(3000);