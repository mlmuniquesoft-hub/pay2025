'use strict';

var authenticator2 = require('authenticator');
var express = require('express')
var bodyParser = require('body-parser')
var jquery = require('jquery')

var app = express()
var rute=express.Router();
var jsonParser = bodyParser.json()

	app.use(function(req, res){
       res.send(404);
	});
// create application/x-www-form-urlencoded parser
var urlencodedParser = bodyParser.urlencoded({ extended: false })

var formattedKey='';
var formattedToken = '';

app.get('/authenticator/verify',urlencodedParser, function (req, res) {
	//app.use(bodyParser.json({ type: 'application/*+json' }))
	var formattedKey=decodeURIComponent(req.query.key);
	var formattedToken=req.query.token;
	var erdfg=authenticator2.verifyToken(formattedKey, formattedToken);
	let hhfj=JSON.stringify(erdfg);
	if(erdfg=='null'){
		res.send('1');
	}else{
		res.send('0');
	}
})
app.get('/authenticator/set',urlencodedParser, function (req, res) {
	var formattedKey = authenticator2.generateKey();
	var formattedToken = authenticator2.generateToken(formattedKey);
	var user=req.query.user;
	var ggdf=authenticator2.generateTotpUri(formattedKey, user, "Robo Trade", 'SHA1', 6, 30);
	res.send(formattedToken+"+"+formattedKey+"+"+ggdf);
})
app.listen(3000)

