/**
 * Created by yhb15154 on 25/07/2016.
 */

jQuery(document).ready(function($) {
    
    var noDocumentsString = "Alert: Provider has no documents added\n\n";

    var fewDocumentsString = "Alert: Provider has fewer than 5 documents added\n\n";

    var unansweredAfterOneMonthString = "Alert: Provider has 5 or more outstanding messages more than a month old\n\n";

    var unansweredAfterThreeMonthsString = "Alert: Provider has 5 or more outstanding messages more than 3 months old \n\n";

    $('tr').each(function(index){

        var firstIndex = $("table tr").index($(this));

        var dateCol = $(this).children("td").eq(3).text();


        if(dateCol < oneMonth)
        {
            $(this).css("background-color", 'rgba(240, 240, 34, 0.2)');
        }
        if(dateCol < threeMonths)
        {
            $(this).css("background-color", 'rgba(240, 34, 34, 0.2)');
        }
        if(firstIndex == 0 )
        {
            $(this).css("background-color", "white");
        }

        var x = document.getElementById("reviewTable").getElementsByTagName("tr");
        $(x).css("background-color", "white" );

    });

    if(numProviderDocs == 0)
    {
        $('#alertsArea').append(noDocumentsString);
    }else if(numProviderDocs < 5)
    {
        $('#alertsArea').append(fewDocumentsString);
    }

    if(unansweredAfterOneMonth > 5)
    {
        $('#alertsArea').append(unansweredAfterOneMonthString);
    }

    if(unansweredAfterThreeMonths > 5)
    {
        $('#alertsArea').append(unansweredAfterThreeMonthsString);
    }

    function alertFunction()
    {

        alert("message sent");

    }


});
