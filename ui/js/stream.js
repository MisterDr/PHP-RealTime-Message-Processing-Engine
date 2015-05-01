/**
 * @author Djenad Razic
 */

var socket;
var max_rows = 100;


//setInterval(function() {
//    chart_data.addRows([
//        ['24-JAN-15 10:27:44 EUR/GBP, Origin FR',  1000,               747.10,       0.7471]
//    ]);
//
//    chart.draw(chart_data, chart_options);
//}, 1000);

/**
 * Init the sockets
 */
function init() {

    // Host name to provide the sockets
    var host = "ws://localhost:6737/dispatcher";

    try {

        // Try to connect to the dispatcher
        socket = new WebSocket(host);
        console.log('WebSocket with status ' + socket.readyState);

        /**
         * Op open socket
         * @param msg
         */
        socket.onopen = function(msg)
        {
            console.log("Opened socket " + this.readyState);
        };

        /**
         * On message receive
         *
         * @param msg
         */
        socket.onmessage = function(msg)
        {
            console.log("Received: " + msg.data);

            // Remove first row to avoid congestion
            if (chart_data.getNumberOfRows() >= max_rows)
            {
                chart_data.removeRow(0);
            }

            var data = JSON.parse(msg.data);

            // Add rows and draw chart
            chart_data.addRows([data]);
            chart.draw(chart_data, chart_options);
        };

        /**
         * On close socket
         *
         * @param msg
         */
        socket.onclose   = function(msg)
        {
            console.log("Disconnected with status " + this.readyState);
        };
    }
    catch(ex)
    {
        console.log(ex);
    }
}

/**
 * Send message
 * @param msg
 */
function send(msg) {
    try {
        socket.send(msg);
        console.log('Sent: ' + msg);
    }
    catch(ex) {
        console.log(ex);
    }
}

/**
 * Close connection
 */
function quit() {
    console.log("Closed!");
    socket.close();
    socket = null;
}

// Initialize the socket
init();