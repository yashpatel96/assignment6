<?php 

    session_start();
    $db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");
   //$get_recipe = 'SELECT * FROM recipe JOIN feedback ON feedback.recipe_ID = recipe.recipe_ID';
     //$result = $db->query($get_recipe);

    if (isset($_POST["submit"]) && $_POST["submit"])
    {
    $name = $_POST['usrname'];
    $comment = $_POST['comment'];
    $rate = $_POST['star'];
    $user_ID = $_SESSION['id'];
    $recipe_ID = $_POST['recipe_ID'];
    //$recipe_ID = mysql_fetch_array($recipe_ID);
    
    print_r('$recipe_ID');
       

    $insertfeedbackQuery = "INSERT INTO feedback (name, user_ID, recipe_ID, comment, star) VALUES ('$name','$user_ID','$recipe_ID','$comment','$rate')";
                            $insertResult = $db->query($insertfeedbackQuery);
                            if ($insertResult == true)
                            {

                             header("Location: recipedetails.php?recipe_ID=".$recipe_ID);
                              // header("Refresh:0");
                                exit();
                            }
                            else 
                            {
                               echo "Sorry, there was an error insert the row";
                            }
                        
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            Welcomne to Recipe Details page
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    
        
        <link rel="stylesheet" type="text/css" href="large.css" />
        <link rel="stylesheet" type="text/css" href="button.css" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    </head>
   
            
    <body>
        <header>
        <table>
            <tr>
                <td>
                <img src="image/krishna.png" alt=" logo " height="100" width="150"/>
                </td>
                <td>
                <h2>Krishna Dishes - Recipe Details</h2>
                </td>
            </tr>
                
        </table>
        <?php
                if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                    echo '<p>Welcome '.$_SESSION['username'].'!!!</p>';
                    echo '<a href="Logout.php" style="color:lightblue;">Logout</a>';
                } 
                else{
                    echo '<a href="login.php" style="color:lightblue; float:left;">Login</a><a href="signup.php" style="color:lightblue; float:right;">Sign Up</a>';
                }
            ?>
        <hr/>
        </header>
            
        <?php
        //  $checkData = "SELECT feedback.content AS content, feedback.name AS name,feedback.star AS star, recipe.* FROM recipe JOIN feedback ON feedback.recipe_ID = recipe.recipe_ID WHERE recipe.recipe_ID = ".$_GET["recipe_ID"];
        $checkData = "SELECT * FROM recipe  WHERE recipe.recipe_ID = ".$_GET["recipe_ID"];
           $result = $db->query($checkData);
            $row = $result->fetch_array();
            //print_r($row);
            // $row = $row[0];
    
            ?>

                <h2><?php echo $row['recipe_title']; ?></h2>
                <img src="<?php echo $row['recipe_image']; ?>" alt=" logo " height="500" width="750"/>
                <h3>Content of Recipe:</h3>
                <p><?php echo $row['content']; ?> </p>
                <h3>Instuction of Recipe:</h3>
                <p><?php echo $row['instruction']; ?> </p>
                <h3>Ingridents of Recipe:</h3>
                <p><?php echo $row['ingredients']; ?> </p>

        <h4>Posted By : </h4><?php echo 'Date : ' . htmlspecialchars($row['posted_at']) . '.';?>
        

        
        

        <?php $feedbackData = "SELECT COUNT(feedback.star) AS countVote, AVG(feedback.star) AS avarage, recipe.*, feedback.* FROM recipe JOIN feedback ON recipe.recipe_ID = feedback.recipe_ID WHERE recipe.recipe_ID = ".$_GET["recipe_ID"];
            $result = $db->query($feedbackData);
            $row1 = $result->fetch_array();
            ?>
        <h4>Avarage Rating : </h4><?php echo 'Out of 5 : ' . htmlspecialchars($row1['avarage']) . '';?>
        <h4>Number of Vote: </h4><?php echo 'Vote : ' . htmlspecialchars($row1['countVote']) . '';?>

        <h3>Reviews</h3>
        
        <table>
        <tr>
            <td>Name:  </td>
            <td><?php echo $row1['name']; ?></td>
        </tr>
        <tr>
            <td>Comment: </td>
            <td><?php echo $row1['comment']; ?> </td>
        </tr>
        <tr>
            <td>star:  </td>
            <td><?php echo $row1['star']; ?></td>
        </tr>

        </table> 


        

          
     

        <h2>Give Your Feedback</h2>
            <form action="recipedetails.php" id="usrform" method="POST">
                <input type = "hidden" name = "recipe_ID" value = "<?php echo $_GET['recipe_ID']; ?>">
                <p>Name: <input type="text" name="usrname" /></p>
                <p>Comment:</p>
                <p><textarea rows="4" cols="50" name="comment" placeholder="Give your feedback here..." ></textarea></p>
                <p>Rate My Recipe out of 5: </p>
                <p><button class="value-button" id="decrease1" onclick="counter(event,'DELETE', 'increase1', 'decrease1', 'number1')" value="Decrease Value">-</button>
                <input type="number"  id="number1" value="0" name="star"/>
                <button class="value-button" id="increase1" onclick="counter(event,'ADD', 'increase1', 'decrease1', 'number1')" value="Increase Value">+</button>
                </p>
                <p></p>
                <p>
                    <?php
                    if($_SESSION['id']){
                    echo '<input type="submit" value="submit" name="submit" />';
                    }
                    else
                    echo '<p style = "color:red";>For feedback and Voting the recipe; You have to Log into the page First!!!</p>'
                    ?>
                </p>
            </form>

            <p></p>
            <p><a href="index.php" >Back to Main page</a></p>

            <script type="text/javascript" src="validator.js"></script>

        <footer> 
            <hr/>
            
            <p>&copy; 2021 Ypc350  All rights reserved.</p>
        </footer>   

    </body>
     
</html>