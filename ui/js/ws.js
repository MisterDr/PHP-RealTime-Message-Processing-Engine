/**
 * Web socket class
 *
 * @author Djenad Razic
 *
 */


var Ws = function () {

    var socket;
    var host;
    var WSLOGGING = false;

    /**
     * Singleton pattern
     */
    if ( arguments.callee._singletonInstance )
        return arguments.callee._singletonInstance;

    arguments.callee._singletonInstance = this;

    /**
     * Initialize
     */
    this.init = function(host, msgCallback) {
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
                if (WSLOGGING) {
                    console.log("Opened socket " + this.readyState);
                }
            };

            /**
             * On message receive
             *
             * @param msg
             */
            socket.onmessage = function(msg)
            {
                if (WSLOGGING) {
                    console.log("Received: " + msg.data);
                }

                var obj = JSON.parse(msg.data);

                msgCallback(obj.context, obj.message);
            };

            /**
             * On close socket
             *
             * @param msg
             */
            socket.onclose   = function(msg)
            {
                if (WSLOGGING) {
                    console.log("Disconnected with status " + this.readyState);
                }
            };
        }
        catch(ex)
        {
            console.log(ex);
        }
    };

    /**
     * Rest like request
     *
     * This will call specific controller/method/params method
     *
     * @param request
     */
    this.send = function(request) {
        socket.send(request);
    };
};
