var express = require('express'),
	app = module.exports = express.createServer(),
	io = require('socket.io').listen(app),
	mongoose = require('mongoose'),
	session = require('./controllers/session_controller'),
	message = require('./controllers/message_controller');

// Servidor basico de Express, solo para contenido estatico

app.configure(function() {
	app.use(express.static(__dirname + '/public'));
});

// Coneccion a la DB  

mongoose.connect('mongodb://localhost/demo-chat');

// Comienza Express

app.listen(3000, function () {
	console.log('Servidor de express corriento en el puerto %d en el modo %s ', app.address().port, app.settings.env)
})

// Añadir listeners al socket

io.sockets.on('connection', function (socket) {
	// Handle chat logins

	socket.on('login attempt', function (data) {
		session.login(io, socket, data);
	});

	// handhe chat logouts

	socket.on('logout attempt', function (data) {
		session.logout(io, socket, data);
	});

	// handle messages

	socket.on('message', function (data) {
		message.message(io, socket, data);
	});

	socket.on('disconnect', function (data) {
		session.disconnect(io, socket, data);
	});


})

