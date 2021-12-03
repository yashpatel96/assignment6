setInterval (refreshVoteCount,10000)
var lastUpdate = Date.now();

function refreshVoteCount() 
{
    var httpModule = XMLHttpRequest();

    httpModule.onreadystatechange = function() 
    {
        if (httpModule.status == 200 && httpModule.readyState == 4)
        {
            lastUpdate = Date.now();
            var result = httpModule.responseText;
            var jsonArray = JSON.parse(result);

            for (var i = 0; i < jsonArray.length; i++)
            {
                var currentRow = jsonArray[i];
                var recipeID = currentRow.recipe_ID;
                var voteCountPTag = document.getElementById("Vote-count-for-recipe-", recipeID);

                if (voteCountPTag)
                {
                    voteCountPTag.innerHTML = currentRow.vote_count + 'votes' ;

                }
            }
        }
    }
    httpModule.open("GET", "showRecords.php?lastdt=" + lastUpdate, true);

    httpModule.send();
   
}

function ajaxVote(e)
{
    console.log("Event Registration Works!!!");
    var buttonID = e.cureentTarget.id;
    var recipeID = buttonID.split("-")[3];

    console.log(recipeID);
    var httpModule = new XMLHttpRequest();
    httpModule.open("GET", "showRecords.php?recipe_ID=" + recipeID, true);

    httpModule.send();

}

var buttons = document.getElementsByClassName("vote-buttons");

for( var i = 0; i < buttons.length; i++)
{
    button[i].addEventListener("click", ajaxVote);
}






/*function ajax_request()
{
    var letter = document.getElementById("input_letter").value;  
    var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () 
        {  
            if(this.readyState == 4 && this.status == 200) 
            {
                var to_recipe;
                var results = JSON.parse(this.responseText);
                console.log(results);

                if (results.length > 0) 
                    {
                    to_recipe = "<table border='1px'>";
                    to_recipe += "<tr>";
                    to_recipe += "<th>"; to_recipe += "Feedback_ID"; to_recipe += "</th>";
                    to_recipe += "<th>"; to_recipe += "Name"; to_recipe += "</th>";
                    to_recipe += "<th>"; to_recipe += "comment"; to_recipe += "</th>";
                    to_recipe += "<th>"; to_recipe += "star"; to_recipe += "</th>";
                    to_recipe += "</tr>";
                    for (var i = 0; i < results.length; i++) 
                        {
                        var json_result = results[i];
                        to_recipe += "<tr>";
                        to_recipe += "<td>"; to_recipe += json_result.feedback_ID; to_recipe += "</td>";
                        to_recipe += "<td>"; to_recipe += json_result.name; to_recipe += "</td>";
                        to_recipe += "<td>"; to_recipe += json_result.comment; to_recipe += "</td>";
                        to_recipe += "<td>"; to_recipe += json_result.star; to_recipe += "</th>";
                        to_recipe += "</tr>";
                        }
                    to_recipe += "</table>";
                    }
                else
                {
                        to_recipe = "There is no Feedback '"+letter+"'";
                }

                document.getElementById("display_records").innerHTML = to_show;
            }

        }
        xmlhttp.open("GET", "show_Records.php?q=" + letter, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("q="+letter);
}

document.getElementById("input_letter").addEventListener("keyup",ajax_request);
*/