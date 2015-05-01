/**
 * @author Djenad Razic
 */

var chart_data;
var chart_options;
var chart;

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

/**
 * Setup chart on load
 */
function drawChart() {

    // Set the chart data to update from stream
    chart_data = google.visualization.arrayToDataTable([
        ['Info',                'Amount Sell',           'Amount Buy',   'Rate'],
        ['24-JAN-15 10:27:44 EUR/GBP, Origin FR, 123',  1000,               747.10,       0.7471],
        ['24-JAN-15 10:27:44 EUR/GBP, Origin FR, 123',  1000,               747.10,       0.7471],
        ['24-JAN-15 10:27:44 EUR/GBP, Origin FR, 123',  1000,               747.10,       0.7471],
        ['24-JAN-15 10:27:44 EUR/GBP, Origin FR, 123',  1000,               747.10,       0.7471]
    ]);

    // Set chart options
    chart_options = {
        title : 'Currency trade',
        vAxis: {
            title: "Amount sell/buy/rate",
            logScale: true
        },
        hAxis: {title: "Info"},
        seriesType: "bars"
    };

    // Init and draw chart
    chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(chart_data, chart_options);
}