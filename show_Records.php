
<?php

include("recipedetails.php");
session_start();
$db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");

if ($db -> connect_error) 
	{
	   die ("Connection failed: " . $db -> connect_error);
	}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["recipe_ID"]))
	{
		$recipe_ID = trim($_GET["recipe_ID"]);

		if(intval($recipe_ID) > 0)
		{
			$q ="INSERT INTO feedback (feedback_ID, recipe_ID, star) VALUES ()"

			$result = $db -> query($q);

		}
		$q = 'SELECT COUNT(feedback.star) AS countVote, AVG(feedback.star) AS avarage , users.user_ID, user_name, avtar, recipe.user_ID, recipe.recipe_ID, content, instruction, posted_at, ingredients, recipe_image, star, feedback.feedback_ID,feedback.recipe_ID 
		FROM users LEFT JOIN recipe ON (users.user_ID = recipe.user_ID)
		LEFT JOIN feedback ON feedback.recipe_ID =recipe.recipe_ID
		GROUP BY recipe.recipe_ID ';

		$result = db -> query($q);
		$phpArray = array();
		while ($row = $result -> fetch_assoc())
		{
			$phpArray[] = $row;
		}
		$jsonResult = json_encode($phpArray);
		echo($jsonResult);
	}

	$lastUpdate = $_GET["lastdt"];
	$lastUpdateSeconds = $lastUpdate / 1000;
	$formatedDate = date("Y-m-d H:i:s", $lastUpdateSeconds);
	$q = "SELECT feedback_ID FROM feedback Where lastdt > '$formatedDate'";

	$result = $db -> query($q);

	if ($result -> num_rows > 0)
	{
		$q = 'SELECT COUNT(feedback.star) AS countVote, AVG(feedback.star) AS avarage , users.user_ID, user_name, avtar, recipe.user_ID, recipe.recipe_ID, content, instruction, posted_at, ingredients, recipe_image, star, feedback.feedback_ID,feedback.recipe_ID 
			FROM users LEFT JOIN recipe ON (users.user_ID = recipe.user_ID)
			LEFT JOIN feedback ON feedback.recipe_ID =recipe.recipe_ID
			GROUP BY recipe.recipe_ID ';

			$result = $db -> query($q);

			$phpArray = array();

			while ($row = $result -> fetch_assoc())
			{
				$phpArray[] =$row;

			}
			$jsonResult = json_encode($phpArray);

			echo($jsonResult);
		}
		else 
		{
			echo("[]");
		}


/*
	$q = $_GET['q'];

	$db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");
	
	if ($db -> connect_error) 
	{
	   die ("Connection failed: " . $db -> connect_error);
	}

	$q="SELECT * FROM feedback WHERE name LIKE '".$q."%'  ";

$r=$db->query($q);

$m=array();


 

while($row = $r->fetch_assoc())
 {
$m[]=$row;  
}

$JSON_response = json_encode($m);

echo $JSON_response;


$db->close();
*/

?>
