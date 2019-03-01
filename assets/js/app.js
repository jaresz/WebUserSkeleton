var $ = require('jquery');
console.log('app.js');
require('../css/app.scss');

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var greet = require('./greet');

$(document).ready(function() {
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
});