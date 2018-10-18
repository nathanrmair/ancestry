jQuery(document).ready(function ($) {


    const PIECHARTOVERVIEWMESSAGES = $('#pieChartOverviewMessages');

    const BARCHARTREGISTRATIONS = $('#barChartRegistrations');

    const PIECHARTVISITORPROFILE = $('#pieChartVisitorProfile');


    //graph functions for the reportsOverview page
    var messagesOverviewPieChart = new Chart(PIECHARTOVERVIEWMESSAGES, {

        type: 'doughnut',
        data: {
            labels: ["Read", "Unread"],
            datasets: [{
                label: 'Read versus unread messages',
                data: [totalRead, totalUnread],
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
            scales: {}
        }

    });


    ////Need to get timestamps added to provider, visitor and user tables
    var registrationsBreakdownBar = new Chart(BARCHARTREGISTRATIONS, {
        type: 'bar',
        data: {
            labels: ["Total", "Visitors", "Providers"],
            datasets: [{
                label: 'total registrations',
                data: [totalUsers, totalVisitors, totalProviders],
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
            animate:false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
        


    });

    var visitorProfilePieChart = new Chart(PIECHARTVISITORPROFILE, {

        type: 'doughnut',
        data: {
            labels: ["Fully Registered", "Profile Incomplete", "No Registered Ancestors"],
            datasets: [{
                label: 'profiles completed',
                data: [totalRead, totalUnread],
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
            scales: {}
        }

    });

});

