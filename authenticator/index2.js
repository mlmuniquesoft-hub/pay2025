var express = require('express')
var speakeasy = require("speakeasy");
var app = express();
var secret = speakeasy.generateSecret({length: 20});
app.get("/set", function(req, res){
	res.send("Hello");
});
