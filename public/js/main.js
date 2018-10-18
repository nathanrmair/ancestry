jQuery(document).ready(function($) {

    const CHART = $('#myChartMessages');

    const PIECHART = $('#pieChartMessages');

    const POLARCHART = $('#polarChartMessages');

    const PIECHARTPROVIDER = $('#pieChartProvider');

    const BARCHARTBREAKDOWN = $('#barChartBreakdown');

    //graph functions for the reportsProviderSummary
    var providerPieChart = new Chart(PIECHARTPROVIDER,{


        type: 'doughnut',
        data: {
            labels: ["Read", "Unread"],
            datasets: [{
                label: 'Read versus unread messages',
                data: [viewRead, viewUnread],
                backgroundColor: [
                    // read section
                    'rgba(34, 137, 240, 0.2)',
                    //unread section
                    'rgba(240, 34, 34, 0.2)',
                    'rgba(54, 162, 235, 0.2)'

                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255,99,132,1)',
                    'rgba(255, 206, 86, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {

            }
        }
    });

    var messageBreakdownBar = new Chart(BARCHARTBREAKDOWN, {

        type: 'bar',
        data: {
            labels: ["Total", "More than 1 month", "More than 3 months"],
            datasets: [{
                label: 'Breakdown of unread messages',
                data: [viewTotal, unansweredAfterOneMonth, unansweredAfterThreeMonths],
                backgroundColor: [
                    //total unread messages
                    'rgba(34, 137, 240, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(240, 34, 34, 0.2)'


                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'



                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }


    });







    var lineChart = new Chart(CHART, {

        type: 'bar',
        data: {
            labels: ["Read", "Unread", "Total"],
            datasets: [{
                label: 'Read versus unread messages',
                data: [dataRows[18], dataRows[39], dataRows[59]],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'


                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }


    });

    var myPieChart = new Chart(PIECHART,{
        type: 'doughnut',
        data: {
            labels: ["Read", "Unread"],
            datasets: [{
                label: 'Read versus unread messages',
                data: [dataRows[18], dataRows[39]],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'

                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {

            }
        }
    });

    var myPolarChart = new Chart(POLARCHART,{
        type: 'polarArea',
        data: {
            labels: ["Read", "Unread"],
            datasets: [{
                label: 'Read versus unread messages',
                data: [dataRows[18], dataRows[39]],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'

                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {

            }
        }
    });
});