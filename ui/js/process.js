/**
 * @author Djenad Razic
 */

$(document).ready(function() {

    // Test the messages
    $('#btnTestReceive').click(function() {

        var sell = Math.floor(Math.random() * 1000);
        var buy = Math.floor(Math.random() * 1000);
        var rate = Math.random();

        $.ajax({
            type: 'POST',
            data: {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": sell, "amountBuy": buy, "rate": rate, "timePlaced" : "24-JAN-15 10:27:44", "originatingCountry" : "FR"},
            url: '/receiver/receive'
        });
    });

    // Start all processes
    $('#btnStart').click(function() {
        $.ajax({
            url: '/process/startAll',
            success: function() {
                location.reload();
            }
        });
    });

    // Populate table with processes
    $.getJSON('/process/getList','', function(data) {

        for (var obj in data)
        {
            // Create the process list
            var str = "<tr><td>" + obj + "</td><td>" + data[obj] + "</td><td><input process-id='" + obj + "' type='checkbox' checked='checked'></td></tr>";

            $('#processList').find('tbody:last').append(str);

            // Initialize the switch
            $("[type='checkbox']").bootstrapSwitch({onSwitchChange: function(event, state) {
                if (! state) {
                    $.ajax({
                        url: '/process/close/' + $(this).attr('process-id'),
                        success : function() {
                            location.reload();
                        }
                    });
                }
            }});
        }
    });
});