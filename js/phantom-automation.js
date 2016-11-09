// args fpr
var system = require('system');
var args = system.args;

// definitions
var page = new WebPage(), testindex = 0, loadInProgress = false;

var pluginSlug = 'redirection';
var formLogin = args[1];
var formPassword = args[2];
var urlAccesBackoffice = args[3];
var urlDownloadPlugin = urlAccesBackoffice + '/plugin-install.php?tab=plugin-information&plugin=redirection';
var urlPluginsInactifs = urlAccesBackoffice+"/plugins.php?plugin_status=inactive";
var boolGenerateImage = 0;      // bool : génération ou non d'images pour le debug
var boolFinish = 0;             // bool : arrêt des traitements si une anomalie est levée


// methodes
page.onConsoleMessage = function(msg) {
    console.log(msg);
};

page.onLoadStarted = function() {
    loadInProgress = true;
    console.log("load started");
};

page.onLoadFinished = function() {
    loadInProgress = false;
    console.log("load finished");
};


page.onError = function(msg, trace) {
    console.log("page.onError");
    var msgStack = ['ERROR: ' + msg];
    if (trace && trace.length) {
        msgStack.push('TRACE:');
        trace.forEach(function(t) {
            msgStack.push(' -> ' + t.file + ': ' + t.line + (t.function ? ' (in function "' + t.function +'")' : ''));
        });
    }
    console.error(msgStack.join('\n'));
};




////////////////////////////////////////////
//  Etapes pour l'activation
////////////////////////////////////////////

var steps = [
    function() {
        // 1 - form sigon backoffice
        page.open(urlAccesBackoffice);
    },

    function() {
        // 2 - set infos into form
        if (boolFinish == 0){
            if (boolGenerateImage == 1)     page.render('debut2.png');

            boolFinish = page.evaluate(function(formLogin, formPassword) {
                if (document.getElementById("user_login") && document.getElementById("user_pass")){
                    document.getElementById("user_login").value = formLogin;
                    document.getElementById("user_pass").value = formPassword;
                    return 0;
                }
                else {
                    // error : fields not found in the page
                    console.log('Fields not found: is url backoffice correct?');
                    return 1;
                }
            }, formLogin, formPassword);
        }

        if (boolFinish == 1)        phantom.exit();
    },

    function() {
        // 3 - submit signon form
        if (boolGenerateImage == 1)     page.render('debut3.png');

        boolFinish = page.evaluate(function() {
            if (document.getElementById("loginform")){
                document.getElementById("loginform").submit();
                return 0;
            }
            else {
                console.log('No form found');
                return 1;
            }
        });

        if (boolFinish == 1)        phantom.exit();
    },

    function(){
        // 4 - load plugin page
        if (boolGenerateImage == 1)     page.render('debut4.png');

        boolFinish = page.evaluate(function() {
            if (document.getElementById("login_error")){
                console.log('Invalid login and/or password')
                return 1
            }
            else {
                return 0;
            }
        })
        if (boolFinish == 1)        phantom.exit();

        page.open(urlDownloadPlugin);
    },

    function(){
        // 5 - click for install plugin
        if (boolGenerateImage == 1)     page.render('debut5.png');

        boolFinish = page.evaluate(function() {

            if (document.getElementById("error-page"))
            {
                // user don't have rights to install plugins
                console.log("Can't install plugin: incorrect user rights?")
                return 1;
            }
            else
            {
                var elementExists = document.getElementById("plugin_install_from_iframe");
                if (elementExists){
                    document.getElementById("plugin_install_from_iframe").click();
                    return 0;
                }
                else {
                    // button not show: plugin already installated
                    console.log('Plugin already installed')
                    return 0;
                }
            }
        });

        if (boolFinish == 1)        phantom.exit();

    },

    function(){
        // 6 - load page plugins
        if (boolGenerateImage == 1)     page.render('debut6.png');
        page.open(urlPluginsInactifs);
    },

    function(){
        // 7 - activate plugin
        if (boolGenerateImage == 1)     page.render('debut7.png')

        // clic pour activer le plugin
        boolFinish = page.evaluate(function(pluginSlug) {
            var trPluginsInactive = document.getElementsByClassName('inactive');
            var i = 0;
            var pluginFound = 0;
            for (i=0; i < trPluginsInactive.length; i++){
                if (trPluginsInactive[i].getAttribute('data-slug') == pluginSlug)
                {
                    // bon slug : cette ligne est celle de l'extension à activer
                    pluginFound = 1;
                    trPluginsInactive[i].querySelector('.activate').firstChild.click();
                    var lienActivatePlugin = trPluginsInactive[i].querySelector('.activate').firstChild;
                    if (lienActivatePlugin){
                        lienActivatePlugin.click()
                        return 1;
                    }
                }
            }

            if (pluginFound == 0)   return 2;

        }, pluginSlug);

        if (boolFinish == 1){
            console.log('Plugin successfully activated!');
        }
        else if (boolFinish == 2){
            console.log('Plugin not found, already activated?');
        }
        else {
            console.log('No activation');
        }
    }

];


///////////////////////////////////////
//  Boucle des traitements Phantomjs
///////////////////////////////////////

interval = setInterval(function() {
    if (!loadInProgress && typeof steps[testindex] == "function") {
        console.log("-- step " + (testindex + 1));
        steps[testindex]();
        testindex++;
 }
    if(typeof steps[testindex] != "function") {
        phantom.exit();
    }
}, 100);
