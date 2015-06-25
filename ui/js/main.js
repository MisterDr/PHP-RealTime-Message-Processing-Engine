/**
 * @author Djenad Razic
 */

// Global definitions
var WS;

$(document).ready(function() {

    WS = new Ws();

    // Init controller
    // Basically you can cobble around the site from various sources/servers/services
    WS.init('ws://localhost:3767/controller', function(context, data) {

        switch (context)
        {
            // Get our async result and put it in the place
            case "test/getLoginView":
                $('#loginPart').append(data);
                break;
        }
    });

    // Send test data to the controller method
    $('#btnTest').click(function() {
        WS.send("test/getLoginView");
    });
});