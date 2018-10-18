$(function() {

    const VISITORMESSAGES = $('#visitorMessagesSentAndReceived');


    var visitorMessagesPieChart = new Chart(VISITORMESSAGES,{

        type: 'doughnut',
        data: {
            labels: ["Sent", "Received"],
            datasets: [{
                label: 'Sent versus received messages',
                data: [sentMails, receivedMails],
                backgroundColor: [
                    // sent section
                    'rgba(34, 137, 240, 0.2)',
                    //received section
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



    
});
