
/**
 * Created by clement on 09/11/2016.
 */
var system = require('system');
// process args
var args = system.args;

var login = args[1];
var password = args[2];
console.log('LOGIN : ' + login)
console.log('pass : ' + password)



phantom.exit();